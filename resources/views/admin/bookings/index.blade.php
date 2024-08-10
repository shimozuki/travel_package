@extends('layouts.app')

@section('content')
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
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body p-0">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Number Phone</th>
                                    <th>Date</th>
                                    <th>Travel Package</th>
                                    <th>Bukti Pembayaran</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $booking->name }}</td>
                                    <td>{{ $booking->email }}</td>
                                    <td>{{ $booking->number_phone }}</td>
                                    <td>{{ $booking->date }}</td>
                                    <td>{{ $booking->travel_package->location }}</td>
                                    <td>
                                        @if ($booking->bukti)
                                        <a href="#" class="view-proof" data-url="{{ Storage::url($booking->bukti) }}" data-toggle="modal" data-target="#proofModal">Lihat Bukti</a>
                                        @else
                                        Belum Melakukan Pembayaran
                                        @endif
                                    </td>
                                    <td>
                                        @if ($booking->status == 0)
                                        <span class="text-danger">Belum Lunas</span>
                                        @elseif ($booking->status == 1)
                                        <span class="text-success">Lunas</span>
                                        @else
                                        <span class="text-muted">Status Tidak Diketahui</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (auth()->user()->is_admin == 1)
                                        <form onclick="return confirm('are you sure ?');" class="d-inline-block" action="{{ route('admin.bookings.destroy', [$booking]) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </button>
                                        </form>
                                        @elseif (auth()->user()->is_admin == 2)
                                        <a href="{{ route('download.ticket', $booking) }}" class="btn btn-primary">Lihat Tiket</a>
                                        @endif

                                        @if ($booking->status == 0 && auth()->user()->is_admin == 1) <!-- Button hanya muncul jika status 0 -->
                                        <button class="btn btn-sm btn-success verify-payment"
                                            data-id="{{ $booking->id }}"
                                            title="Verifikasi Pembayaran">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        @endif
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer clearfix">
                        {{ $bookings->links() }}
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
    $(document).on('click', '.view-proof', function() {
        let url = $(this).data('url');
        let extension = url.split('.').pop().toLowerCase();

        if (extension === 'jpg' || extension === 'jpeg' || extension === 'png' || extension === 'gif') {
            $('#proofImage').attr('src', url);
            $('#proofImage').show();
            $('#proofDocument').hide();
        } else {
            $('#proofDocument').attr('src', url).show();
            $('#proofImage').hide();
        }
    });
</script>
<script>
    $(document).on('click', '.verify-payment', function() {
        const bookingId = $(this).data('id');
        console.log(bookingId);

        // SweetAlert untuk konfirmasi
        Swal.fire({
            title: 'Konfirmasi',
            text: "Apakah Anda yakin ingin memverifikasi pembayaran ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, verifikasi!',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ url("admin/bookings") }}/' + bookingId + '/verify', // menyesuaikan URL 
                    type: 'POST', // gunakan POST method untuk mengupdate
                    data: {
                        _token: '{{ csrf_token() }}', // kirimkan CSRF token
                    },
                    success: function(response) {
                        // SweetAlert untuk keberhasilan
                        Swal.fire({
                            title: 'Sukses!',
                            text: 'Pembayaran berhasil diverifikasi.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload(); // reload halaman untuk update status terlihat
                        });
                    },
                    error: function(xhr) {
                        // SweetAlert untuk kesalahan
                        Swal.fire({
                            title: 'Terjadi Kesalahan!',
                            text: 'Silakan coba lagi.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        console.log(xhr);
                    }
                });
            }
        });
    });
</script>
@endsection