<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\MensajeController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\CronoController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\GraduandoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TextoController;
use App\Http\Controllers\DataSesionController;
use App\Http\Controllers\DataSeminarController;
use App\Http\Controllers\ZoomApiService;
use App\Http\Controllers\MatriculasCajaController;

Route::middleware(['guest'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
});

Auth::routes();

Route::group(['middleware' => ['Administrador']], function () {
    Route::resource('users', UserController::class);
    Route::resource('modulos', ModuloController::class);
    Route::resource('mensajes', MensajeController::class);
    Route::resource('matriculas', MatriculaController::class);
    Route::resource('cronos', CronoController::class);
    Route::resource('salas', SalaController::class);
    Route::resource('certificado', GraduandoController::class);
    Route::resource('entr', EntregaController::class);
    Route::resource('data-sesions', DataSesionController::class);
    Route::resource('data-seminars', DataSeminarController::class);
    Route::resource('matriculasbox', MatriculasCajaController::class);
    Route::resource('recursos', RecursoController::class);
    Route::resource('tareas', TareaController::class);
    Route::get('/simular/{id}', [App\Http\Controllers\UserController::class, 'simular'])->name('simulaUsuario');
    Route::get('/admin', [App\Http\Controllers\Administrador::class, 'homeAdmin'])->name('administrador');
    Route::get('/anuncios', [App\Http\Controllers\Administrador::class, 'index'])->name('anunciosAdm');
    Route::get('/desactivados', [App\Http\Controllers\UserController::class, 'deshabilitados'])->name('users.del');
    Route::post('/u-check', [App\Http\Controllers\UserController::class, 'usercheck'])->name('users.check');
    Route::post('/u-buscar', [App\Http\Controllers\UserController::class, 'userbuscar'])->name('users.buscar');
    Route::get('/restoreUser/{id}', [App\Http\Controllers\UserController::class, 'restoreUser'])->name('restoreUser');
    Route::patch('/restore', [App\Http\Controllers\UserController::class, 'restore'])->name('restore');
    Route::post('/weekModule', [App\Http\Controllers\ModuloController::class, 'changeWeek'])->name('changeWeek');
    Route::post('/mod-add-matr', [App\Http\Controllers\MatriculaController::class, 'modulo_est'])->name('modulo_est');
    Route::post('docssave', [App\Http\Controllers\MatriculaController::class, 'doc_save'])->name('docMatr.save');
    Route::delete('docsdel', [App\Http\Controllers\Estudiante::class, 'doc_del'])->name('docMatr.delete');
    Route::post('profilepicdel', [App\Http\Controllers\Estudiante::class, 'profilepicdel'])->name('ProfilePic.delete');
    Route::get('/log', [App\Http\Controllers\Administrador::class, 'logUser'])->name('logUser');
    Route::post('/repositorioadd', [App\Http\Controllers\Administrador::class, 'repositorioadd'])->name('recording.store');
    Route::delete('/repositoriodel/{id}', [App\Http\Controllers\Administrador::class, 'repositoriodel'])->name('recording.destroy');
    Route::get('/inscripciones', [App\Http\Controllers\Administrador::class, 'inscripcioneslist']);
    Route::delete('/inscripciones/{id}', [App\Http\Controllers\Administrador::class, 'inscripcionesDel'])->name('inscripciones.destroy');
    Route::get('/certificados/{id}', [App\Http\Controllers\Administrador::class, 'addCertificado'])->name('addCertificado');
    Route::get('/listausu', [App\Http\Controllers\Administrador::class, 'verListaUsers'])->name('verListaUsers');
    Route::post('ajusteNotas', [App\Http\Controllers\Administrador::class, 'ajusteNotas'])->name('ajusteNotas');
    Route::post('cambiarNota', [App\Http\Controllers\Administrador::class, 'editaNota'])->name('editaNota');
    Route::post('promedio', [App\Http\Controllers\Administrador::class, 'promedios'])->name('promedios');
    Route::get('promedios-totales', [App\Http\Controllers\Administrador::class, 'promedios_totales'])->name('promedios_totales');
    Route::get('certificados-int', [App\Http\Controllers\Administrador::class, 'c_int_generator']);
    Route::post('certificados-int-create', [App\Http\Controllers\Administrador::class, 'c_int_creator'])->name('certificados-int-create');
    //
    Route::get('/financiero/{id}', [App\Http\Controllers\FinancieroController::class, 'index'])->name('fnz');
    Route::get('/fnz/{id}', [App\Http\Controllers\FinancieroController::class, 'procesarPago'])->name('procesarPago');
    Route::patch('/fnzupd/{id}', [App\Http\Controllers\FinancieroController::class, 'updatePago'])->name('updatePago');
    Route::get('/pagos-detalle/{id}', [App\Http\Controllers\FinancieroController::class, 'pagodetalle'])->name('pagodetalle');
    //
    Route::post('/pagareadd/{id}', [App\Http\Controllers\FinancieroController::class, 'pagareAdd'])->name('pagareAdd');
    Route::delete('/pagareDel/{id}', [App\Http\Controllers\FinancieroController::class, 'pagareDel'])->name('pagare.del');
    Route::patch('/pagare-archivar/{id}', [App\Http\Controllers\FinancieroController::class, 'pagareArchivar'])->name('pagare.save');
    Route::delete('/pagoDel/{id}', [App\Http\Controllers\FinancieroController::class, 'pagoDel'])->name('pago.del');
    Route::get('/buscaest/{id}', [App\Http\Controllers\UserController::class, 'buscar'])->name('buscar');
    Route::get('/buscacode/{id}', [App\Http\Controllers\UserController::class, 'buscarCodigo'])->name('buscar.codigo');
    //
    Route::post('/usuadmclave', [App\Http\Controllers\UserController::class, 'usuadmclave'])->name('usuadmclave');
    Route::get('/generarlista/{id}', [App\Http\Controllers\UserController::class, 'generarLista'])->name('generarLista');
    //
    Route::get('/oferta', [App\Http\Controllers\TextoController::class, 'verProgramas'])->name('verProgramas');
    Route::get('/convenios', [App\Http\Controllers\TextoController::class, 'verConvenios'])->name('verConvenios');
    Route::get('/textos/{id}/{slug}', [App\Http\Controllers\TextoController::class, 'verTexto'])->name('verTexto');
    Route::post('/textoedicion', [App\Http\Controllers\TextoController::class, 'textoedicion'])->name('textoedicion');
    Route::get('/texto-del/{id}', [App\Http\Controllers\TextoController::class, 'textodelete'])->name('textodelete');
    Route::post('/svprog', [App\Http\Controllers\TextoController::class, 'savePrograma'])->name('savePrograma');
    //
    Route::get('/blacklist/{id}', [App\Http\Controllers\Administrador::class, 'blacklist'])->name('blacklist');
    Route::get('/repone/{id}', [App\Http\Controllers\Administrador::class, 'repone'])->name('repone');
    Route::get('/sabana', [App\Http\Controllers\Administrador::class, 'sabana'])->name('sabana');
    Route::get('/info-gral', [App\Http\Controllers\Administrador::class, 'infoGeneral'])->name('infoGeneral');
    Route::post('/info-graladd', [App\Http\Controllers\Administrador::class, 'infoGeneralStore'])->name('infogeneral.store');
    Route::delete('/infoGeneral/{id}', [App\Http\Controllers\Administrador::class, 'infoGeneralDelete'])->name('infoGeneral.destroy');
    //
    Route::get('/encuestas', [App\Http\Controllers\Administrador::class, 'encuestas'])->name('encuestas');
    Route::post('/archivarModulo', [App\Http\Controllers\Administrador::class, 'archivarModulo'])->name('archivarModulo');
    Route::post('/matricularModulo', [App\Http\Controllers\Administrador::class, 'matricularModulo'])->name('matricularModulo');
    //
    Route::get('/listazoom/{id}', [App\Http\Controllers\ZoomApiService::class, 'index'])->name('listaZoom');
    Route::post('/listazoom-add', [App\Http\Controllers\ZoomApiService::class, 'createMeeting'])->name('createMeeting');
    Route::post('/edit-meeting/{id}', [App\Http\Controllers\ZoomApiService::class, 'editarMeeting'])->name('evento.edit');
    Route::delete('/listazoom-del', [App\Http\Controllers\ZoomApiService::class, 'deleteEvent'])->name('evento.destroy');
    //
    Route::get('/mensajecontrol', [App\Http\Controllers\MensajeController::class, 'listaCompleta'])->name('listaMsj');
    Route::get('/crt-notas/{id}', [App\Http\Controllers\Administrador::class, 'addCNotas'])->name('addCNotas');
    Route::post('/addpruebas', [App\Http\Controllers\Administrador::class, 'crearPruebasAptitud'])->name('crearPruebasAptitud');
    Route::post('/registro-academico/{id}', [App\Http\Controllers\Administrador::class, 'addRegistroAc'])->name('addRegistroAc');
    //
    Route::post('/generadorbckp', [App\Http\Controllers\Administrador::class, 'generadorbckp'])->name('generadorbckp');
    Route::get('/generadorsiet', [App\Http\Controllers\Administrador::class, 'siet'])->name('generadorsiet');
    //Pruebas de aptitud
    Route::get('/pa', [App\Http\Controllers\Administrador::class, 'paindex'])->name('paindex');
    Route::post('/pa/{id}', [App\Http\Controllers\Administrador::class, 'paEdit'])->name('prueba.edit');
    Route::post('/pa-create', [App\Http\Controllers\Administrador::class, 'paCrear'])->name('prueba.crear');
    Route::delete('/pa-delete/{id}', [App\Http\Controllers\Administrador::class, 'paBorrar'])->name('prueba.borrar');
    //asignación docente
    Route::post('/asignar-modulo', [App\Http\Controllers\Administrador::class, 'asignarModulo'])->name('asignar-modulo');
    Route::post('/cambiarAsignacion', [App\Http\Controllers\Administrador::class, 'cambiarAsignacion'])->name('cambiarAsignacion');
    
});

Route::group(['middleware' => ['Estudiante']], function () {
    Route::get('/estudiante', [App\Http\Controllers\Estudiante::class, 'index'])->name('estudiante');
    Route::get('/modulo/{id}', [App\Http\Controllers\ModuloController::class, 'elModulo'])->name('estudiante.md');
    Route::get('/entrega/{id}', [App\Http\Controllers\Estudiante::class, 'vertarea'])->name('vertarea');
    Route::get('/entrega-seminario/{id}', [App\Http\Controllers\Estudiante::class, 'verTareaSeminario'])->name('vertarea.seminario');
    Route::post('/entrega', [App\Http\Controllers\Estudiante::class, 'entregar'])->name('entregar');
    Route::post('/entrega-seminario', [App\Http\Controllers\Estudiante::class, 'entregarSeminario'])->name('entregar.seminario');
    Route::get('/devolverEntrega/{id}', [App\Http\Controllers\Estudiante::class, 'devolverEntrega'])->name('devolverEntrega');
    Route::post('/sendmsj', [App\Http\Controllers\Estudiante::class, 'enviarMSJ'])->name('enviarMSJ');
    Route::get('/vermsj/{id}', [App\Http\Controllers\Estudiante::class, 'verMsj'])->name('verMsj');
    Route::post('estudiantedocs', [App\Http\Controllers\Estudiante::class, 'estudiantedocs'])->name('estudiantedocs');
    Route::get('/siet', [App\Http\Controllers\Estudiante::class, 'siet'])->name('siet');
    Route::post('/siet_add', [App\Http\Controllers\Estudiante::class, 'sietAdd'])->name('sietAdd');
    Route::get('/downloadr/{id}', [App\Http\Controllers\Estudiante::class, 'downloadr'])->name('downloadr');
    Route::get('/downloadf/{id}', [App\Http\Controllers\Estudiante::class, 'downloadf'])->name('downloadf');
    Route::get('/profile', [App\Http\Controllers\UserController::class, 'profileView']);
    Route::get('/crt/{id}', [App\Http\Controllers\Estudiante::class, 'certificado'])->name('verCertificado');
    Route::get('/ayuda', [App\Http\Controllers\Estudiante::class, 'ayuda']);
    Route::get('/sala/{id}', [App\Http\Controllers\ModuloController::class, 'sala'])->name('sala');
    Route::get('/meeting', [App\Http\Controllers\ModuloController::class, 'meeting'])->name('meeting');
    Route::get('/contrato/{id}/{slug}', [App\Http\Controllers\FinancieroController::class, 'vercontrato'])->name('vercontrato');
    Route::get('/financiero', [App\Http\Controllers\FinancieroController::class, 'financiero'])->name('financiero');
    Route::post('/financieroadd', [App\Http\Controllers\FinancieroController::class, 'financieroAddEst'])->name('financieroAddEst');
    Route::get('/pagare/{id}', [App\Http\Controllers\FinancieroController::class, 'verPagare'])->name('verPagare');
    //
    Route::post('/sendpush', [App\Http\Controllers\Notpush::class, 'sendNotification'])->name('send.web-notification');
    //
    Route::view('/encuesta-modulo', 'estudiante.encuesta_m');
    Route::post('/escuesta-save', [App\Http\Controllers\Estudiante::class, 'guardaEncuesta'])->name('save.poll');
    //Mesa de ayuda
    Route::post('/mesayuda', [App\Http\Controllers\Estudiante::class, 'mesayuda'])->name('mesayuda.add');
    Route::get('/mesayuda/{id}', [App\Http\Controllers\Estudiante::class, 'mesaticket'])->name('mesayuda.ver');
    //Prueba de Aula
    Route::get('/aula', [App\Http\Controllers\AulaController::class, 'index']);
    Route::get('/aula-index', [App\Http\Controllers\AulaController::class, 'datos']);
    Route::get('/aula-modulo/{id}', [App\Http\Controllers\AulaController::class, 'modulo']);
    Route::get('/prueba-apt/{id}', [App\Http\Controllers\Estudiante::class, 'verPruebaAptitud'])->name('prueba.ver');
    //Generar Carnet
    Route::get('/carne-estudiantil', [App\Http\Controllers\Estudiante::class, 'verCarnet'])->name('carnet.ver');
});

Route::group(['middleware' => ['Docente']], function () {
    Route::resource('recursos', RecursoController::class);
    Route::resource('tareas', TareaController::class);
    Route::get('/docente', [App\Http\Controllers\Docente::class, 'index'])->name('docente');
    Route::get('/dmodulo/{id}/gr/{grupo}', [App\Http\Controllers\ModuloController::class, 'moduloDocente'])->name('modulo.view');
    Route::get('/getMsj/{id}', [App\Http\Controllers\Docente::class, 'verMsj'])->name('getMsj');
    Route::post('rspMsj', [App\Http\Controllers\Docente::class, 'responderMsj'])->name('responder');
    Route::patch('revision/{id}', [App\Http\Controllers\Docente::class, 'revision'])->name('revision');
    Route::post('attendance1', [App\Http\Controllers\Docente::class, 'asistencia'])->name('asistencia');
    Route::post('attendance2', [App\Http\Controllers\Docente::class, 'asistencia_edit'])->name('asistencia_edit');
    Route::delete('attendance3', [App\Http\Controllers\Docente::class, 'asistencia_delete'])->name('asistencia_delete');
    Route::post('notas', [App\Http\Controllers\Docente::class, 'notas'])->name('notas');
    Route::post('anuncio', [App\Http\Controllers\Docente::class, 'anuncio'])->name('anuncio');
    Route::delete('anuncio-delete', [App\Http\Controllers\Docente::class, 'anuncioBorra'])->name('anuncio-delete');
    Route::get('seminarios', [App\Http\Controllers\Docente::class, 'seminarios'])->name('seminarios');
    Route::post('reagendar', [App\Http\Controllers\Docente::class, 'agendarSeminario'])->name('reagendar.sesion');
    Route::post('save-session', [App\Http\Controllers\Docente::class, 'editarSesion'])->name('editar.sesion');
    Route::post('rtr-session', [App\Http\Controllers\Docente::class, 'retroSession'])->name('retro.sesion');
    Route::get('entregashow/{id}', [App\Http\Controllers\Docente::class, 'verEntrega'])->name('entrega.ver');
    Route::get('pruebas-aptitud', [App\Http\Controllers\Docente::class, 'pruebasAptitud'])->name('pruebas-aptitud.ver');
    Route::post('pruebas-aptitud/{id}', [App\Http\Controllers\Docente::class, 'pruebasValorar'])->name('pruebas-aptitud.valorar');
});

Route::group(['middleware' => ['Inscrito']], function () {
    Route::get('/inscrito', [App\Http\Controllers\Inscrito::class, 'index'])->name('inscrito');
});
/*
Arreglar el permiso para que el estudiante inactivo también pueda enviar pagos.
Route::group(['middleware' => ['Inactivo']], function () {
    Route::get('/recibo/{id}', [App\Http\Controllers\FinancieroController::class, 'verrecibo'])->name('verrecibo');
    Route::get('/contrato/{id}/{slug}', [App\Http\Controllers\FinancieroController::class, 'vercontrato'])->name('vercontrato');
    Route::get('/inactivo', [App\Http\Controllers\FinancieroController::class, 'financiero'])->name('inactivo');
    Route::post('/financieroadd', [App\Http\Controllers\FinancieroController::class, 'financieroAddEst'])->name('financieroAddEst');
    Route::get('/pagare/{id}', [App\Http\Controllers\FinancieroController::class, 'verPagare'])->name('verPagare');
    
});
*/

Route::resource('inbox', MensajeController::class)->middleware('auth');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('inicio')->middleware('auth');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('inicio')->middleware('auth');
Route::get('/userfiles/{slug}',[App\Http\Controllers\FilesProtect::class, 'archivo'])->name('ft')->middleware('auth');
Route::get('/recibo/{id}', [App\Http\Controllers\FinancieroController::class, 'verrecibo'])->name('verrecibo')->middleware('auth');
Route::post('/inscripcion', [App\Http\Controllers\NuevaInscripcion::class, 'inscripcionInstel']);
//
Route::post('/fcm-token', [HomeController::class, 'updateToken'])->name('fcmToken');
Route::post('/send-notification',[HomeController::class,'notification'])->name('notification');
Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@create')->name('register');

Route::impersonate();

Route::get('/salir', function () {
    Session::forget('msjFinanciero');
    return redirect('/impersonate/leave');
});