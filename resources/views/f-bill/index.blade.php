@extends('layouts.app')

@section('template_title')
    F Bill
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('F Bill') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('f-bills.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                        
										<th>User</th>
										<th>Valor</th>
										<th>Cuotas</th>
										<th>Saldo</th>
										<th>Fecha</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fBills as $fBill)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $fBill->user }}</td>
											<td>{{ $fBill->valor }}</td>
											<td>{{ $fBill->cuotas }}</td>
											<td>{{ $fBill->saldo }}</td>
											<td>{{ $fBill->fecha }}</td>

                                            <td>
                                                <form action="{{ route('f-bills.destroy',$fBill->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('f-bills.show',$fBill->id) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('f-bills.edit',$fBill->id) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
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
                {!! $fBills->links() !!}
            </div>
        </div>
    </div>
@endsection
