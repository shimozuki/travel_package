<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Boarding Pass</title>
    <link rel="stylesheet" href="{{ asset('css/boarding-pass.css') }}">
</head>

<body>
    <div class="boarding-pass">
        <header>
            <svg class="logo">
                <use xlink:href="#alitalia"></use>
            </svg>
            <div class="flight">
                <small>Kapal</small>
                <strong>AL 101</strong>
            </div>
        </header>
        <section class="cities">
            <div class="city">
                <small>Name : Mr. {{ $ticket->name }}</small>
                <small>Phone : {{ $ticket->number_phone }}</small>
                <small>Email : {{ $ticket->travel_package->slug }}</small>
            </div>
            <div class="city">
                <small>Code Booking</small>
                <strong>#A{{$ticket->id}}</strong>
            </div>
        </section>
        <section class="infos">
            <div class="places">
                <div class="box">
                    <small>Terminal</small>
                    <strong><em>W</em></strong>
                </div>
                <div class="box">
                    <small>Gate</small>
                    <strong><em>C3</em></strong>
                </div>
                <div class="box">
                    <small>Seat</small>
                    <strong>14B</strong>
                </div>
                <div class="box">
                    <small>Class</small>
                    <strong>E</strong>
                </div>
            </div>
            <div class="times">
                <div class="box">
                    <small>Boarding</small>
                    <strong>11:05</strong>
                </div>
                <div class="box">
                    <small>Departure</small>
                    <strong>11:35</strong>
                </div>
                <div class="box">
                    <small>Duration</small>
                    <strong>2:15</strong>
                </div>
                <div class="box">
                    <small>Arrival</small>
                    <strong>13:50</strong>
                </div>
            </div>
        </section>
        <section class="strap">
            <div class="box">
                <div class="passenger">
                    <small>Booking Date</small>
                    <strong>{{ $ticket->date }}</strong>
                </div>
                <div class="date">
                    <small>Expired</small>
                    <strong>{{ $ticket->end_date }}</strong>
                </div>
            </div>
            <div class="qrcode">
                <img src="https://th.bing.com/th/id/OIP.-9N4K3Syg-OgbET8dgDwqAHaHa?w=173&h=180&c=7&r=0&o=5&dpr=1.5&pid=1.7" alt="" width="100%">
            </div>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.5.0/html2pdf.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi untuk menyimpan halaman sebagai PDF
            function saveAsPDF() {
                var element = document.querySelector('.boarding-pass');
                html2pdf().from(element).save('boarding-pass.pdf');
            }

            // Fungsi untuk mencetak halaman
            function printScreen() {
                window.print();
            }

            // Panggil fungsi untuk menyimpan PDF atau mencetak halaman setelah beberapa detik
            setTimeout(function() {
                saveAsPDF();
                // printScreen(); // Jika ingin mencetak alih-alih menyimpan sebagai PDF
            }, 10); // Tunggu 1 detik sebelum menyimpan atau mencetak
        });
    </script>
</body>

</html>
