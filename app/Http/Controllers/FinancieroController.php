<?php

namespace App\Http\Controllers;

use App\Models\MatriculasCaja;
use Illuminate\Http\Request;

use App\Models\FConcepto;
use App\Models\Matricula;
use App\Models\Programa;
use App\Models\FBill;
use App\Models\Siet;
use App\Models\User;
use App\Models\User_doc;

use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Luecano\NumeroALetras\NumeroALetras;
use Carbon\Carbon;

use Auth, Session, Image, Storage;

class FinancieroController extends Controller
{

    public function index($id)
    {
        if ($id == "pagos-realizados") {
            $pendientes = FConcepto::where('fecha', '>', Carbon::now()->subDays(30)->format('Y-m-d'))->orderBy('fecha', 'DESC')->get();
            return view('recibo.index', compact('pendientes'));
        } else {
            $creditos = FBill::orderBy('created_at', 'DESC')->get();
            return view('recibo.creditos', compact('creditos'));
        }
    }

    public function verrecibo($id)
    {
        $dataRecibo = FConcepto::where('idRecibo', $id)->get();

        $formatter = new NumeroALetras();
        $formatter->apocope = true;

        //Solo el administrador o el usuario que es titular del recibo puede verlo
        if (Auth::user()->rol == "Administrador" || Auth::user()->id == $dataRecibo->first()->user) {
            return view('recibo.recibo', compact('dataRecibo', 'formatter'));
        }
    }

    public function financiero()
    {
        //$pagare = FBill::where('user',Auth::user()->id)->where('status',0)->where('contratoID', 'NOT LIKE', '%NOTA%')->orderBy('fecha','DESC')->first();
        $deuda = FBill::where('user', Auth::user()->id)->where('status', 0)->get();
        $financiero = FConcepto::where('user', Auth::user()->id)->where('status', 1)->where('idRecibo', 'NOT LIKE', 0)->orderBy('cuota', 'ASC')->orderBy('fecha', 'ASC')->get();
        return view('estudiante.financiero', compact('financiero', 'deuda'));
    }

    public function pagodetalle($id)
    {
        $dataGet = explode('-', $id);
        $conceptos = ($dataGet[1] == '0' ? FConcepto::where('user', $dataGet[0])->whereNull('idRecibo')->get() : FConcepto::where('idRecibo', $dataGet[1])->get());
        $datosUser = ($dataGet[0] == '0' ? (object) ["doc" => ''] : User::where('id', $dataGet[0])->withTrashed()->first());
        //return response()->json($datosUser);
        $nRecibo = ($dataGet[1] == '0' ? FConcepto::where('fecha', '>', '2023-01-01')->orderBy('idRecibo', 'DESC')->first()->idRecibo + 1 : $dataGet[1]);
        return view('recibo.editpago', compact('conceptos', 'nRecibo', 'datosUser'));
    }

    public function financieroAddEst(Request $request)
    {
        //return response()->json($request);

        //Carga el comprobante en PDF o Imagen
        if ($request->hasFile('comprobante')) {
            $idUnico = md5(uniqid(rand(), true)) . '.' . $request->file('comprobante')->extension();
            $request->file('comprobante')->storeAs('userfiles/financiero/', $idUnico);
        } else {
            $idUnico = $request->comprobanteID;
        }

        //Realiza el cargue de los conceptos
        //COMO ADMINISTRADOR
        if (Auth::user()->rol == "Administrador") {
            //Elimina todos los conceptos con el idRecibo
            Fconcepto::where('idRecibo', $request->idRecibo)->delete();
            //Si se trata de un envío del estudiante, borra ese registro pendiente
            Fconcepto::where('user', $request->userPay)->whereNull('idRecibo')->delete();
            //Crea los nuevos conceptos
            for ($i = 1; $i <= $request->nConceptos; $i++) {
                if ($request['valor_' . $i] > 0) {
                    FConcepto::create([
                        'concept' => $request['concept_' . $i],
                        'fecha' => $request->fecha,
                        'valor' => $request['valor_' . $i],
                        'idRecibo' => $request->idRecibo,
                        'idConcepto' => $idUnico,
                        'user' => $request->userPay,
                        'status' => 1,
                        'formaPago' => $request->formaPago,
                        'observ' => $request->observ,
                        'pagareID' => $request['pagareID_' . $i],
                        'cuota' => $request['cuota_' . $i]
                    ]);
                }
            }
            $avisoFinal = 'Pago procesado.';
        }

        //COMO ESTUDIANTE
        if (Auth::user()->rol == "Estudiante") {
            FConcepto::create([
                'concept' => $request->concept,
                'fecha' => $request->fecha,
                'valor' => $request->valor,
                'idRecibo' => NULL,
                'idConcepto' => $idUnico,
                'user' => Auth::user()->id,
                'status' => 0,
                'formaPago' => NULL,
                'observ' => NULL,
                'pagareID' => NULL,
                'cuota' => NULL
            ]);
            $avisoFinal = 'Se envió el comprobante con éxito. Pronto lo procesaremos.';
        }
        return redirect()->back()->with('success', $avisoFinal);
    }

    public function procesarPago($id)
    {
        $fConcepto = FConcepto::find($id);
        $lastRecibo = FConcepto::where('fecha', '>', '2023-01-01')->orderBy('idRecibo', 'DESC')->first()->idRecibo;
        return view('recibo.edit', compact('fConcepto', 'lastRecibo'));
    }

    public function updatePago(Request $request, $id)
    {
        $elConcpt = FConcepto::find($id);

        $elConcpt->update([
            'status' => 1,
            'idRecibo' => $request->idRecibo,
            'fecha' => $request->fecha,
            'formaPago' => $request->formaPago,
            'concept' => $request->concept,
            'observ' => $request->observ,
            'valor' => $request->valor,
            'pagareID' => $request->pagareID,
            'cuota' => $request->cuota
        ]);

        if ($request->pagareID != NULL) {
            $miPagare = FBill::where('user', $elConcpt->user)->first();
            $nSaldo = $miPagare->saldo - $request->valor;
            $miPagare->update(['saldo' => $nSaldo]);
        }

        return redirect()->back()->with('success', 'Pago procesado con éxito');

    }

    public function pagoDel($id)
    {
        $elPago = FConcepto::find($id);
        $file_old = 'userfiles/financiero/' . $elPago->idConcepto;

        if (Storage::exists($file_old)) {
            Storage::delete($file_old);
        }
        $elPago->delete();
        return redirect()->back()->with('danger', 'Pago eliminado');
    }

    public function vercontrato($id, $slug)
    {
        $laMatricula = MatriculasCaja::where('user',$slug)->where('estado', 'ACTIVO');
        $programas = Programa::all();
        $formatter = new NumeroALetras();
        $formatter->apocope = true;
        //return view('recibo.contrato', compact('formatter','user','programas'));
        $pdf = Pdf::loadView('recibo.contrato', compact('formatter','laMatricula','programas','id'));
        $pdf->setPaper('letter');
        
        $elID = md5(uniqid(rand(), true)) . ".pdf";
        User_doc::create(['user' => $slug, 'file' => $elID, 'descr' => "CSE " . substr($laMatricula->first()->getEstudiante()->cod, -4) . '-' . $laMatricula->first()->periodo]);
        Storage::put("userfiles/profiles/" . $elID, $pdf->output());
        return redirect()->back()->with('success', 'Se generó el contrato con éxito.');
        //return $pdf->stream();
    }


    public function verPagare($id)
    {
        $dt = explode('-', $id);
        $datos = FBill::find($dt[1]);
        $formatter = new NumeroALetras();
        $formatter->apocope = true;
        //Si el pagare es un preview
        if($dt[0] == "0"){
            //El pagare es solo visible para el usuario y el admin
            if (Auth::user()->rol == "Administrador" || Auth::user()->id == $datos->user) {
                return view('recibo.pagare', compact('datos', 'formatter'));
            }
        } else {
        //El pagaré se genera
            $pdf = Pdf::loadView('recibo.pagare', compact('datos', 'formatter'));
            $pdf->setPaper('letter');
            $elID = md5(uniqid(rand(), true)) . ".pdf";
            //Si se trata de un registro nuevo
            User_doc::updateOrCreate(
                ['user' => $datos->user, 'descr' =>  "Pagaré ".$datos->contratoID],
                array(
                    'user' => $datos->user, 
                    'file' => $elID, 
                    'descr' => "Pagaré ".$datos->contratoID,
                )
            );
            Storage::put("userfiles/profiles/" . $elID, $pdf->output());
            return redirect()->route('users.edit', $datos->user)->with('warning', 'Se generó el pagaré y ahora es visible al usuario para su firma');
        }
    }

    public function pagareAdd(Request $request, $id)
    {
        //Define las fechas de pago
        $plazos = "";
        for ($i=1; $i <= $request->cuotas; $i++) { 
            $plazos .= $request['fecha'.$i].'|';
        }

        //Define si es un pagaré o un crédito sencillo a través del ID
        if ($request->c_documento == null) {
            $idContrato = "NOTAC-" . date('ymdhis');
            $codeudor = NULL;
        } else {
            $idContrato = $request->contratoID;
            $codeudortmp = [
                "doc" => $request->c_documento,
                "nombre" => $request->c_nombre,
                "doc_ex" => $request->c_doc_ex,
                "direccion" => $request->c_direccion,
                "ciudad" => $request->c_ciudad,
                "barrio" => $request->c_barrio,
                "telefono" => $request->c_telefono
            ];
            $codeudor = json_encode($codeudortmp);
        }
        $tomador = [
            "doc" => $request->t_documento,
            "nombre" => $request->t_nombre,
            "doc_ex" => $request->t_doc_ex,
            "direccion" => $request->t_direccion,
            "ciudad" => $request->t_ciudad,
            "barrio" => $request->t_barrio,
            "telefono" => $request->t_telefono
        ];
        //Almacena en la BD
        FBill::updateOrCreate(
            ['id' => $id],
            array(
                'user' => $request->user,
                'contratoID' => $idContrato,
                'deudor' => json_encode($tomador),
                'codeudor' => $codeudor,
                'semestre' => $request->semestre,
                'cicloAc' => $request->cicloAc,
                'valor' => $request->valor,
                'cuotas' => $request->cuotas,
                'saldo' => $request->valor,
                'fecha' => $request->fecha,
                'status' => '0',
                'otros' => Auth::user()->nombres,
                'matricula' => $request->creditoMatr,
                'plan' => $plazos
            )
        );
        return redirect()->back()->with('success', 'Cambios realizados con éxito');
    }

    public function pagareDel($id)
    {
        $obligacion = FBill::find($id);
        //Reviso si tiene pagos asociados para desvincularlos
        $chPag = FConcepto::where('pagareID', $obligacion->contratoID)->update(['pagareID' => NULL]);
        //Elimino la obligacion
        $obligacion->delete();
        return redirect()->back()->with('danger', 'Obligación eliminada');
    }
    public function pagareArchivar(Request $request, $id)
    {
        $data = FBill::find($id);
        $data->update(['status' => $request->accion]);
        $respuesta = ['archivado', 'desarchivado'];
        return redirect()->back()->with('danger', 'El pagaré/crédito ha sido ' . $respuesta[(int) $request->accion] . ' con éxito');
    }
}