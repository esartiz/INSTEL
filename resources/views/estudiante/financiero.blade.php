@extends('layouts.instel')

@section('template_title')
    Servicio de Tesorería y Pagos
@endsection

@section('content')

    <div class="container">

        @if ($message = Session::get('success'))
            <div class="alert alert-success">{{ $message }}</div>
        @endif

        @if (Session::exists('msjFinanciero'))
            <div class="alert alert-danger">{!! Session::get('msjFinanciero')[0] !!}</div>
        @endif

        <div class="row">
            <div class="col-md-12 text-center" style="background-color: #00468c10">
                <b>Envíenos su comprobante de pago</b>

                <form class="row" method="POST" role="form" enctype="multipart/form-data"
                    action="{{ route('financieroAddEst') }}" id="">
                    @csrf
                    <div class="col-3">
                        <label for="" class="form-label">Archivo</label>
                        <input type="file" class="form-control" name="comprobante" accept="image/*, application/pdf"
                            required>
                        <small id="helpId" class="form-text text-muted">Imagen o PDF</small>
                    </div>

                    <div class="col-3">
                        <label for="" class="form-label">Concepto</label>
                        <input type="text" class="form-control" name="concept" id="concepto" required>
                        <small id="helpId" class="form-text text-muted">Indique de qué se trata el pago realizado</small>
                    </div>

                    <div class="col-2">
                        <label for="" class="form-label">Valor $</label>
                        <input type="number" class="form-control" name="valor" id="" value="" required>
                        <small id="helpId" class="form-text text-muted">Valor pagado sin $ ni puntos</small>
                    </div>

                    <div class="col-2">
                        <label for="" class="form-label">Fecha</label>
                        <input type="date" class="form-control" name="fecha" id="" value="{{ date('Y-m-d') }}"
                            required>
                        <small id="helpId" class="form-text text-muted">Fecha en la que se realizó el pago</small>
                    </div>

                    <div class="col-2">
                        <label for="" class="form-label">_</label>
                        <div class="d-grid gap-2">
                            <button type="submit" name="" id="" class="btn btn-info">Enviar</button>
                        </div>
                    </div>


                </form>

            </div>

            <h5 style="border-bottom: 1px solid #c1dbf6; color: #00468C; font-weight: 500;" class="mt-3">
                Nuestros métodos de Pago
            </h5>

            <div class="alert alert-secondary" role="alert">
                <div class="row text-center align-items-center">
                    <div class="col-md-3">
                        <img src="https://wompi.com/assets/img/home/logo-wompi.svg" style="height: 25px; margin-bottom: 10px;">
                        <form action="https://checkout.wompi.co/p/" method="GET" onsubmit="return pagoWompiSend(this);">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text">$</span>
                                </div>
                                <input type="text" class="form-control" id="pagoWompi">
                                <div class="input-group-append">
                                  <span class="input-group-text">.00</span>
                                </div>
                            </div>
                            <small class="msjWompi">(+3% de Comisión Wompi)</small>

                            <input type="hidden" name="public-key" value="pub_prod_b7AVKOujBzXfsZixiHL8ETfPHlVE3om4" />
                            <input type="hidden" name="currency" value="COP" />
                            <input type="hidden" name="amount-in-cents" class="pagoWompi" value="" />
                            <input type="hidden" name="reference" value="INSTEL_{{ Auth::user()->doc . '-' . date('YmdHis') }}" />
                            <input type="hidden" name="customer-data:email" value="{{ Auth::user()->email }}" />
                            <input type="hidden" name="customer-data:full-name" value="{{ Auth::user()->nombres }} {{ Auth::user()->apellidos }}" />
                            <input type="hidden" name="customer-data:phone-number" value="{{ Auth::user()->telefono }}" />
                            <input type="hidden" name="data-customer-data:phone-number-prefix" value="+57">
                            <input type="hidden" name="customer-data:legal-id" value="{{ Auth::user()->doc }}" />
                            <input type="hidden" name="customer-data:legal-id-type" value="{{ Auth::user()->tipoDoc }}" />
                            <button type="submit" class="btn btn-sm btn-dark">Pagar con Wompi</button>
                          </form>
                    </div>
                    <div class="col-md-3">
                        <img src="{{ asset('images/logos/bancolombia.png') }}"
                            alt=""><br>
                        Cuenta de Ahorros:<br> 82370089589
                    </div>
                    <div class="col-md-3">
                        <img src="{{ asset('images/logos/banco_bogota.png') }}" alt="">
                        <br>Cuenta de Ahorros: <br>48702670-0
                    </div>
                    <div class="col-md-3">
                        <img src="{{ asset('images/logos/banco_avvillas.png') }}"
                            alt="">
                        <br>Cuenta Corriente: <br>15803595-6
                    </div>
                </div>
            </div>

            <div class="row row-cols-md-2">

                @isset($deuda)
                @include('estudiante.boxDeuda')
                <!-- END OTRA DEUDA -->
                @endisset
                
                <div class="col">
                    <h5 style="border-bottom: 1px solid #c1dbf6; color: #00468C; font-weight: 500;">
                        {{ (isset($deuda) ? 'Otros pagos realizados' : 'Pagos realizados')}}
                    </h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Recibo</th>
                                <th scope="col">Concepto</th>
                                <th scope="col">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($financiero->where('cuota','>', 100)->merge($financiero->whereNull('pagareID'))->sortBy('fecha') as $item)
                                <tr>
                                    <th scope="row">
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                            onclick="verContratoSE('{{ $item->idRecibo }}','recibo')">
                                            {{ $item->idRecibo }}
                                        </button>
                                    <td>
                                        {{ $item->concept }}<br>
                                        <small class="muted-text">{{ $item->fecha }}</small>
                                    </td>
                                    <td style="text-align: right">$ {{ number_format($item->valor, 0, '', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            
        </div>
    </div>

    <!-- Ver Recibo -->
    <div class="modal fade" id="verPagareM" tabindex="-1" aria-labelledby="verPagareMLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="printRec" name="printf" src="" width="100%" height="600"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-danger" id="imprimirContrato">Imprimir</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.wompi.co/libs/js/v1.js" data-public-key="pub_prod_b7AVKOujBzXfsZixiHL8ETfPHlVE3om4"></script>
@endsection

@section('scripts')
<script>
    let comision = 0;
    $('#pagoWompi').change(function(){
        comision = $(this).val() * 1.03;
        $('.msjWompi').text("Se cobrarán $" + comision.toLocaleString() + " (+3% de comisión)");
        //msjWompi
        $('.pagoWompi').val(comision + "00")
    });

    function pagoWompiSend(){
        return confirm('El pago se realizará por un valor total de $' + comision.toLocaleString() + ' que incluye el 3% de recargo por pagos mediante Wompi');
    }
</script>

@endsection