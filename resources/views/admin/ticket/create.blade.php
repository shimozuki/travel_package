@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 d-flex justify-content-between">
                    <h1 class="m-0">{{ __('Form Create') }}</h1>
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-primary"> <i class="fa fa-arrow-left"></i> </a>
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
                    <div class="card p-3">
                        <form method="post" action="{{ route('admin.tickets.store') }}" enctype="multipart/form-data">
                            @csrf 
                            <div class="form-group row border-bottom pb-4">
                                <label for="title" class="col-sm-2 col-form-label">From</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" name="port_from_id" value="{{ old('port_from_id') }}" id="port_from_id" placeholder="example: Bangsal">
                                </div>
                            </div>
                            <div class="form-group row border-bottom pb-4">
                                <label for="title" class="col-sm-2 col-form-label">To</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" name="port_to_id" value="{{ old('port_to_id') }}" id="port_to_id" placeholder="example: Bangsal">
                                </div>
                            </div>
                            <div class="form-group row border-bottom pb-4">
                                <label for="title" class="col-sm-2 col-form-label">Departure</label>
                                <div class="col-sm-10">
                                <input type="date" class="form-control" name="departure_date" value="{{ old('departure_date') }}" id="departure_date" placeholder="example: Bangsal">
                                </div>
                            </div>
                            <div class="form-group row border-bottom pb-4">
                                <label for="title" class="col-sm-2 col-form-label">Price</label>
                                <div class="col-sm-10">
                                <input type="number" class="form-control" name="price" value="{{ old('price') }}" id="price" placeholder="example: 300000">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Save</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection


@section('styles')
<style>
.ck-editor__editable_inline {
    min-height: 200px;
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#description' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
@endsection