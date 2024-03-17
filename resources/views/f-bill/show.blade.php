@extends('layouts.app')

@section('template_title')
    {{ $fBill->name ?? 'Show F Bill' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show F Bill</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('f-bills.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>User:</strong>
                            {{ $fBill->user }}
                        </div>
                        <div class="form-group">
                            <strong>Valor:</strong>
                            {{ $fBill->valor }}
                        </div>
                        <div class="form-group">
                            <strong>Cuotas:</strong>
                            {{ $fBill->cuotas }}
                        </div>
                        <div class="form-group">
                            <strong>Saldo:</strong>
                            {{ $fBill->saldo }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha:</strong>
                            {{ $fBill->fecha }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
