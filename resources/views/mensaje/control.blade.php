@extends('layouts.app')

@section('template_title')
    Mensaje
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Mensaje') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('mensajes.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Start Date</th>
										<th>End Date</th>
										<th>De</th>
										<th>Para</th>
										<th>Asunto</th>
										<th>Mensaje</th>
										<th>Respuesta</th>
										<th>Status</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mensajes as $mensaje)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            
											<td>{{ $mensaje->start_date }}</td>
											<td>{{ $mensaje->end_date }}</td>
											<td>{{ $mensaje->userDe->nombres.' '.$mensaje->userDe->apellidos }}</td>
											<td>{{ $mensaje->userPara->nombres.' '.$mensaje->userPara->apellidos }}</td>
											<td>{{ $mensaje->asunto }}</td>
											<td>{{ $mensaje->mensaje }}</td>
											<td>{{ $mensaje->respuesta }}</td>
											<td>{{ $mensaje->status }}</td>

                                            <td>
                                                <form action="{{ route('mensajes.destroy',$mensaje->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('mensajes.show',$mensaje->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('mensajes.edit',$mensaje->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
