@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12 justify-content-between d-flex">
                <h1 class="m-0">{{ __('Tickets') }}</h1>
                <a href="{{ route('admin.tickets.create') }}" class="btn btn-primary btn-sm"> <i class="fa fa-plus"></i> </a>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body p-0">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>depatur date</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tickets as $tiket)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tiket->port_from_id }}</td>
                                    <td>
                                        {{ $tiket->port_to_id }}
                                    </td>
                                    <td>{{ $tiket->departure_date }}</td>
                                    <td>{{ $tiket->price }}</td>
                                    <td>
                                        <a href="{{ route('admin.tickets.edit', $tiket->id) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form onclick="return confirm('are you sure ?');" class="d-inline-block" action="#" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer clearfix">
                        {{ $tickets->links() }}
                    </div>
                </div>

            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection