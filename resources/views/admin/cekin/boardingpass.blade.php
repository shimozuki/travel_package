<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Boarding Pass - Karya Bahari</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .boarding-pass {
      display: flex;
      background-color: white;
      border: 2px solid #007bff;
      border-radius: 10px;
      width: 700px;
      height: 250px;
      /* Adjusted height to make the footer visible */
      overflow: hidden;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      position: relative;
    }

    .boarding-pass::before {
      content: "";
      position: absolute;
      top: 50%;
      left: 50%;
      width: 200px;
      height: 200px;
      background-image: url('/frontend/assets/img/karya-bahari-fast-boat_logo.jpg');
      background-size: contain;
      background-position: center;
      background-repeat: no-repeat;
      opacity: 0.1;
      /* Adjust transparency for watermark effect */
      transform: translate(-50%, -50%);
    }

    .left-side,
    .right-side {
      padding: 20px;
      width: 50%;
    }

    .left-side {
      padding: 20px;
      width: 50%;
      border-right: 2px dashed #007bff;
      background-color: #f4faff;
    }

    .header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      /* Memastikan logo berada di sisi yang berlawanan */
      margin-bottom: 20px;
    }

    .jasa-logo {
      width: 20%;
      /* Atur ukuran logo */
      height: auto;
      /* Menjaga proporsi logo */
      margin-left: 20px;
      /* Jarak antara teks dan logo */
    }


    .klu-logo {
      width: 15%;
      /* Adjust the logo size */
      margin-right: 20px;
      /* Add space between the logo and the text */
    }

    .header-text {
      text-align: center;
    }

    .header-text h1 {
      font-size: 14px;
      margin: 0;
      color: #333;
    }

    .header-text h2 {
      font-size: 14px;
      margin: 5px 0;
      color: #555;
    }

    .left-side p {
      font-size: 16px;
      color: #555;
      margin-bottom: 10px;
    }

    .right-side {
      text-align: center;
      padding: 20px;
    }

    textarea {
      width: 80%;
      /* Atur lebar textarea */
      margin-top: 10px;
      /* Jarak di atas textarea */
      padding: 10px;
      /* Jarak di dalam textarea */
      border: 1px solid #007bff;
      /* Warna border */
      border-radius: 5px;
      /* Sudut melengkung */
      font-size: 14px;
      /* Ukuran font */
      color: #333;
      /* Warna font */
    }

    .footer {
      margin-top: 20px;
      font-size: 12px;
      color: #777;
    }

    .print-button {
      position: relative;
      top: 0;
      left: 0;
      margin-top: 330px;
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
    }

    .print-button:hover {
      background-color: #0056b3;
    }

    @media print {
      body * {
        visibility: hidden;
      }

      .boarding-pass,
      .boarding-pass * {
        visibility: visible;
      }

      .boarding-pass {
        position: absolute;
        left: 0;
        top: 0;
      }

      .print-button {
        visibility: hidden;
      }
    }
  </style>
</head>

<body>
  <div class="boarding-pass">
    <div class="left-side">
      <div class="header">
        <img src="{{ asset('frontend/assets/img/klu.png') }}" alt="KLU Logo" class="klu-logo">
        <div class="header-text">
          <h1>Pemerintah Kabupaten Lombok Tengah</h1>
          <h2>"Karya Bahari"</h2>
        </div>
        <img src="{{ asset('frontend/assets/img/jasa_raharja.png') }}" alt="Jasa Raharja Logo" class="jasa-logo">
      </div>
      <p><strong>Nama:</strong> {{ $ticket->name }}</p>
      <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($ticket->date)->format('l, j F Y') }}</p>
      <p><strong>Jam Keberangkatan:</strong> 08:00 AM</p>
      <p><strong>Dari:</strong> {{ $ticket->ticket->port_from_id }}</p>
      <p><strong>Tujuan:</strong> {{ $ticket->ticket->port_to_id }}</p>
    </div>

    <div class="right-side">
      <h2>Boarding Pass</h2>
      <label for="nomor-urut">Nomor Urut:</label>
      <textarea id="nomor-urut" rows="4"></textarea>
      <div class="footer">
        <p>Harap datang 30 menit sebelum keberangkatan</p>
        <p>Terima kasih telah memilih Karya Bahari</p>
      </div>
    </div>
  </div>
  <center><button class="print-button" onclick="window.print()">Cetak</button></center>
</body>

</html>