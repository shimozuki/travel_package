@extends('layouts.app')

@section('content')
<style scoped>
    .disabled-button {
        background-color: #cccccc;
        /* Warna abu-abu untuk menunjukkan tombol tidak aktif */
        border-color: #cccccc;
        /* Sesuaikan warna border dengan background */
        color: #666666;
        /* Sesuaikan warna teks */
        cursor: not-allowed;
        /* Ubah kursor menjadi tanda larangan */
    }
</style>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12 justify-content-between d-flex">
                <h1 class="m-0">{{ __('Booking') }}</h1>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Scan Tiket</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Kode Booking</label>
                            <input type="text" class="form-control" name="code_booking" id="code_booking">
                        </div>
                        <!-- /.form-group -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                Scan Barcode Tiket atau inputkan secara manual.
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body p-0">

                        <table id="table" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Number Phone</th>
                                    <th>Date</th>
                                    <th>Kode Booking</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<!-- Modal for viewing payment proof -->
<div class="modal fade" id="proofModal" tabindex="-1" role="dialog" aria-labelledby="proofModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="proofModalLabel">Bukti Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="proofImage" src="" alt="Bukti Pembayaran" class="img-fluid" />
                <iframe id="proofDocument" src="" style="display:none; width:100%; height:400px;"></iframe>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('#code_booking').on('keyup', function() {
        var codeBooking = $(this).val();
        $.ajax({
            type: 'GET',
            url: '{{ route('admin.loket.search') }}',
            data: { code_booking: codeBooking },
            success: function(response) {
                console.log(response); // Periksa data yang diterima dari server
                if (response.success) {
                    var ticket = response.ticket;
                    var html = '';
                    $.each(ticket, function(index, value) {
                        html += '<tr>';
                        html += '<td>' + (index + 1) + '</td>';
                        html += '<td>' + (value.name || '') + '</td>';
                        html += '<td>' + (value.email || '') + '</td>';
                        html += '<td>' + (value.number_phone || '') + '</td>';
                        html += '<td>' + (value.date || '') + '</td>';
                        html += '<td>' + (value.kode_booking|| '') +'</td>';
                        html += '<td><button class="btn btn-primary" onclick="cetakBoardingPass('+ value.id +')">Cetak</button></td>';
                        html += '</tr>';
                    });
                    $('#table tbody').html(html);
                } else {
                    $('#table tbody').html('');
                }
            }
        });
    });
  });

  function cetakBoardingPass(id) {
    window.open('{{ route('admin.loket.boardingpass') }}?id=' + id, '_blank');
  }
</script>
@endsection