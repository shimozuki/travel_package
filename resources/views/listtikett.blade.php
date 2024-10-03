@extends('layouts.frontend')

@section('content')
<style>
  .modal-custom {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
  }

  .modal-content-custom {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    width: 500px;
  }

  .modal-header-custom {
    padding: 10px;
    border-bottom: 1px solid #ddd;
  }

  .modal-title-custom {
    font-size: 18px;
    font-weight: bold;
  }

  .close-custom {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    cursor: pointer;
  }

  .modal-body-custom {
    padding: 20px;
    overflow-y: auto;
    max-height: 580px;
  }

  .modal-footer-custom {
    padding: 10px;
    border-top: 1px solid #ddd;
    text-align: right;
  }

  .form-group {
    margin-bottom: 15px;
  }

  .form-group label {
    display: block;
    margin-bottom: 5px;
  }

  .form-group select,
  .form-group input[type="date"] {
    width: 100%;
    height: 40px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }

  .form-group input[type="checkbox"] {
    margin-right: 10px;
  }

  .form-control {
    border: 2px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    width: 100%;
    height: 40px;
  }
</style>
<!--==================== HOME ====================-->
<section>
  <div class="swiper-container gallery-top">
    <div class="swiper-wrapper">
      <section class="islands swiper-slide">
        <img src="{{ asset('frontend/assets/img/bali.jpg') }}" alt="" class="islands__bg" />

        <div class="islands__container container">
          <div class="islands__data">
            <h2 class="islands__subtitle">Explore</h2>
            <h1 class="islands__title">Package Travel</h1>
          </div>
        </div>
      </section>
    </div>
  </div>
</section>

<!--==================== POPULAR ====================-->
<section class="section" id="popular">
  <div class="container">
    <span class="section__subtitle" style="text-align: center">All</span>
    <h2 class="section__title" style="text-align: center">
      Package Travel
    </h2>

    <div class="popular__all">
      @if(isset($tickets) && count($tickets) > 0)
      @foreach($tickets as $travel_tiket)
      <article class="popular__card">
        <a href="#">
          <img src="{{ asset('images/Paket-Tour-Labuan-Bajo-Speedboat.jpg') }}" alt="" class="popular__img" />
          <div class="popular__data">
            <h3 class="popular__title">{{ $travel_tiket->port_from_id}} <span>to</span> {{ $travel_tiket->port_to_id }}</h3>
            <h3 class="popular__description">Departure : {{ \Carbon\Carbon::parse($travel_tiket->departure_date)->format('l, d F Y') }}</h3>
            <h3 class="popular__description">Boarding : 08:00 WITA
              <p class="popular__description">Price : Rp.{{ $travel_tiket->price }}</p>
              <br />
              <center><button type="button" class="button nav__button" data-toggle="modal" data-target="#bookingModal" data-ticket-id="{{ $travel_tiket->id }}">Booking</button></center>
          </div>
        </a>
      </article>
      @endforeach
    </div>
  </div>
</section>
<!-- Modal -->
<div id="bookingModal" class="modal-custom">
  <div class="modal-content-custom">
    <div class="modal-header-custom">
      <h5 class="modal-title-custom">Booking Ticket</h5>
      <button type="button" class="close-custom" id="close-modal">&times;</button>
    </div>
    <div class="modal-body-custom" style="">
      <form action="{{ url('/booking') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="ticket_id" id="ticket_id" value="{{ $travel_tiket->id }}">
        <input type="hidden" name="date" id="ticket_id" value="{{ $travel_tiket->departure_date }}">
        <div class="form-group mb-3">
          <label for="nomor_identitas">Nomor Identitas</label>
          <input type="text" class="form-control" id="nomor_identitas" name="nomor_identitas" required>
        </div>
        <div class="form-group mb-3">
          <label for="name">Nama</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group mb-3">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group mb-3">
          <label for="number_phone">Nomor Telepon</label>
          <input type="text" class="form-control" id="number_phone" name="number_phone" required>
        </div>
        <div id="penumpang"></div>
        <div class="form-group mb-3">
          <label for="price">Price (IDR)</label>
          <input type="number" class="form-control" id="price" name="price" value="{{ $travel_tiket->price }}" readonly>
        </div>
        <div class="form-group mb-3">
          <label for="proofOfPayment">Bukti Pembayaran</label>
          <input type="file" class="form-control" id="proofOfPayment" name="proofOfPayment" required>
        </div>
        <div class="form-group mb-3">
          <label for="alamat">Alamat</label>
          <textarea class="form-control" id="alamat" name="alamat" required></textarea>
        </div>
        <button type="button" class="button nav__button" id="tambah_penumpang">Tambah Penumpang</button>
        <div class="modal-footer-custom">
          <button type="button" class="btn btn-secondary" id="batal-modal">Batal</button>
          <button type="submit" class="button nav__button">Booking</button>
        </div>
      </form>
    </div>
  </div>
</div>
@else
<p>Maaf tiket yang Anda cari tidak ditemukan</p>
@endif
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  // Tambahkan event listener pada tombol Tambah Penumpang
  document.getElementById('tambah_penumpang').addEventListener('click', function() {
    var penumpang = document.getElementById('penumpang');
    var newPenumpang = document.createElement('div');
    newPenumpang.innerHTML = `
  <button type="button" class="btn btn-secondary hapus-penumpang">X</button>
  <div class="form-group mb-3">
    <label for="penumpang_nama">Nama Penumpang</label>
    <input type="text" class="form-control" id="penumpang_nama" name="penumpang_name[]">
  </div>
  <div class="form-group mb-3">
    <label for="penumpang_nomor_identitas">Nomor Identitas Penumpang</label>
    <input type="text" class="form-control" id="penumpang_nomor_identitas" name="penumpang_nomor_identitas[]">
  </div>
  `;
    penumpang.appendChild(newPenumpang);

    // Update harga secara otomatis
    var harga = parseInt(document.getElementById('price').value);
    var jumlahPenumpang = penumpang.children.length + 1;
    document.getElementById('price').value = harga * jumlahPenumpang;
  });

  // Tambahkan event listener pada tombol X
  document.getElementById('penumpang').addEventListener('click', function(event) {
    if (event.target.classList.contains('hapus-penumpang')) {
      // Hapus elemen penumpang
      event.target.parentNode.remove();

      // Update harga secara otomatis
      var harga = parseInt(document.getElementById('price').value);
      var jumlahPenumpang = penumpang.children.length + 1;
      if (jumlahPenumpang > 0) {
        document.getElementById('price').value = harga / jumlahPenumpang;
      } else {
        document.getElementById('price').value = harga;
      }
    }
  });

  // Tambahkan event listener pada tombol X
  document.getElementById('penumpang').addEventListener('click', function(event) {
    if (event.target.classList.contains('hapus-penumpang')) {
      // Hapus elemen penumpang
      event.target.parentNode.remove();
    }
  });
  document.getElementById('bookingModal').style.display = 'none';

  document.addEventListener('click', function(event) {
    if (event.target.classList.contains('button')) {
      document.getElementById('bookingModal').style.display = 'block';
    }
  });

  document.getElementById('close-modal').addEventListener('click', function() {
    document.getElementById('bookingModal').style.display = 'none';
  });

  document.getElementById('batal-modal').addEventListener('click', function() {
    document.getElementById('bookingModal').style.display = 'none';
  });
</script>
@endsection