<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-tiket</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .ticket {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .ticket-header {
            background-color: #0d6efd;
            color: white;
            padding: 15px;
        }

        .ticket-section {
            border: 1px solid #ddd;
            padding: 15px;
            margin-top: 15px;
        }

        .qr-code {
            text-align: center;
        }

        .ticket-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div class="text-center mt-3">
        <button class="btn btn-primary" id="download">Download PDF</button>
    </div>
    <div class="ticket" id="ticket">
        <div class="ticket-header text-center">
            <h2>E-tiket</h2>
        </div>

        <div class="ticket-section">
            <h5>DATA PEMESAN</h5>
            <div class="row">
                <div class="col-6">
                    <p><strong>Nama:</strong> {{ $tickets->name }}</p>
                    <p><strong>Email:</strong> {{ $tickets->travel_package->slug }}</p>
                    <p><strong>Telepon:</strong> {{ $tickets->number_phone }}</p>
                    <p><strong>Negara:</strong> Indonesia</p>
                </div>
                <div class="col-6">
                    <p><strong>Tanggal Pesan:</strong> {{ $tickets->date }}</p>
                    <p><strong>Nomor Transaksi:</strong> W0C</p>
                    <p><strong>Masa Berlaku:</strong> {{ $tickets->end_date }}</p>
                </div>
            </div>
        </div>

        <div class="ticket-section">
            <h5>DATA PERJALANAN</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Asal</th>
                        <th>Tujuan</th>
                        <th>Kelas</th>
                        <th>Layanan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>08 April 2020</td>
                        <td>Merak</td>
                        <td>Bakaheuni</td>
                        <td>Reguler</td>
                        <td>Penumpang</td>
                    </tr>
                </tbody>
            </table>
            <p><strong>Jam:</strong> 10:06 - 11:00</p>
        </div>

        <div class="ticket-section">
            <h5>NAMA KAPAL</h5>
            <p>ROYAL NUSANTARA, SHALEM, AMARISA, WIRA ARTHA</p>
        </div>

        <div class="ticket-section">
            <h5>DATA PENUMPANG</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Penumpang</th>
                        <th>Nomor ID</th>
                        <th>Jenis Penumpang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penumpang as $penumpangs)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $penumpangs->name }}</td>
                        <td>{{ $penumpangs->nomor_identitas }}</td>
                        <td>Dewasa</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="ticket-section qr-code">
            <img src="{{ $qrCodeUrl }}" alt="QR Code" width="90" height="90">
            <p>Kode Pemesanan: {{ $tickets->kode_booking }}</p>
        </div>

        <div class="ticket-footer">
            <p><strong>INFORMASI PENTING</strong></p>
            <p>Gunakan e-tiket ini untuk cetak boarding pass di pelabuhan...</p>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- html2pdf.js untuk download PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

    <script>
        document.getElementById('download').addEventListener('click', () => {
            const element = document.getElementById('ticket');
            html2pdf()
                .set({
                    timeout: 30000, // increase timeout to 30 seconds
                    margin: 10, // increase margin to 10mm
                    filename: 'e-ticket.pdf'
                })
                .from(element)
                .save();
        });
    </script>

</body>

</html>