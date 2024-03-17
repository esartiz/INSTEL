@extends('layouts.admin')

@section('template_title')
    Bienvenido al módulo administrador
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">Salas Creadas</span>
                        </div>
                    </div>
                    <div class="card-body row">

                        @foreach ($salasLista as $item)
                            <div class="col-md-4 text-center">
                                <form action="{{ route('salas.destroy',$item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Desea eliminar esta sala del sistema?')"><i class="fa fa-fw fa-trash"></i></button>
                                </form>

                                <form action="{{ route('salas.update', $item->id)}}" method="POST">
                                    {{ method_field('PATCH') }}
                                    @csrf
                                <div style="font-size: 100px;">
                                    <i class="fa-solid fa-person-chalkboard" style="margin-right: 10px"></i>
                                </div>
                                Nombre de la sala:
                                <input type="text" name="n_sala" value="{{ $item->n_sala }}" style="width: 100%">
                                Código sala:
                                <input type="text" name="link_host" value="{{ $item->link_host }}" style="width: 100%">
                                Asignado a:
                                <select class="form-select" name="asignada" id="asignada">
                                    <option value="0">------ Ningún Módulo ------</option>
                                    @foreach ($losModulos as $item2)
                                        <option value="{{ $item2->id }}"@if ($item->asignada == $item2->id) selected @endif>{{ $item2->titulo }} ({{ $item2->user->nombres.' '.$item2->user->apellidos }})</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-outline-primary">Cambiar</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
                <br>

                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">Crear Sala</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('salas.store')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="n_sala" class="form-label">Nombre de la Sala</label>
                                <input type="text" class="form-control" name="n_sala" id="n_sala" placeholder="Ej. Sala de Zoom 1" required>
                                <small id="helpId" class="form-text text-muted">Este nombre le ayudará a identificar la sala</small>
                            </div>

                            <div class="mb-3">
                                <label for="link" class="form-label">Código Zoom</label>
                                <input type="text" class="form-control" name="link_host" id="link_host" aria-describedby="helpId3" placeholder="Ej. 344545255529" required>
                                <small id="helpId3" class="form-text text-muted">Código que genera Zoom</small>
                            </div>

                            <input type="hidden" name="link" value="{{ date('YmdHis')}}">
    
      
                              <div class="mb-3">
                                  <label for="" class="form-label">Asignar al módulo:</label>
                                  <select class="form-select" name="asignada" id="asignada">
                                    <option value="0">------ Ningún Módulo ------</option>
                                    @foreach ($losModulos as $item)
                                          <option value="{{ $item->id }}">{{ $item->titulo }} ({{ $item->user->nombres.' '.$item->user->apellidos }})</option>
                                      @endforeach
                                  </select>
                                  <small id="helpId2" class="form-text text-muted">El módulo en el que se usará esta sala inicialmente</small>
                              </div>

                              <div class="d-grid gap-2">
                                <button type="submit" name="" id="" class="btn btn-primary">Crear Sala</button>
                              </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
