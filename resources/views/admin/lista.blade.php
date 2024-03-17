@extends('layouts.app')

@section('template_title')
    User
@endsection

@section('content')
<table class="table table-striped table-hover" style="background-color: white">
    <thead class="thead">
        <tr>
            <th>No</th>
            
            <th>Cod</th>
            <th>Tipodoc</th>
            <th>Doc</th>
            <th>Doc Ex</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Telefono</th>
            <th>Fecha Nac</th>
            <th>Sexo</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Ciclo</th>

            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                
                <td>{{ $user->cod }}</td>
                <td>{{ $user->tipoDoc }}</td>
                <td>{{ $user->doc }}</td>
                <td>{{ $user->doc_ex }}</td>
                <td>{{ $user->nombres }}</td>
                <td>{{ $user->apellidos }}</td>
                <td>{{ $user->telefono }}</td>
                <td>{{ $user->fecha_nac }}</td>
                <td>{{ $user->sexo }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->rol }}</td>
                <td>{{ $user->ciclo }}</td>

                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
