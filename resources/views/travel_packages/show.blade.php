@extends('layouts.frontend')

@section('content')
<!--==================== HOME ====================-->
<section>
  <div class="swiper-container gallery-top">
    <div class="swiper-wrapper">
      @foreach($travel_package->galleries as $gallery)
      <section class="islands swiper-slide">
        <img src="{{ Storage::url($gallery->images) }}" alt="" class="islands__bg" />

        <div class="islands__container container">
          <div class="islands__data">
            <h2 class="islands__subtitle">Explore</h2>
            <h1 class="islands__title">{{ $gallery->name }}</h1>
          </div>
        </div>
      </section>
      @endforeach
    </div>
  </div>

  <!--========== CONTROLS ==========-->
  <div class="controls gallery-thumbs">
    <div class="controls__container swiper-wrapper">
      @foreach($travel_package->galleries as $gallery)
      <img src="{{ Storage::url($gallery->images) }}" alt="" class="controls__img swiper-slide" />
      @endforeach
    </div>
  </div>
</section>

<section class="blog section" id="blog">
  <div class="blog__container container">
    <div class="content__container">
      <div class="blog__detail">
        {!! $travel_package->description !!}
      </div>
      <div class="package-travel">
        <h3>Booking Now</h3>
        <div class="card">
          <form action="{{ route('booking.store') }}" method="post">
            @csrf
            <input type="hidden" name="travel_package_id" value="{{ $travel_package->id }}">
            <input type="text" name="name" placeholder="Your Name" />
            <input type="email" name="email" placeholder="Your Email" />
            <input type="number" name="number_phone" placeholder="Your Number" />
            <input placeholder="Pick Your Date" class="textbox-n" type="text" name="date" onfocus="(this.type='date')" id="date" />
            <button type="button" id="openPaymentModal" class="button button-booking"><center>Send</center></button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section" id="popular">
  <div class="container">
    <span class="section__subtitle" style="text-align: center">Package Travel</span>
    <h2 class="section__title" style="text-align: center">
      The Best Tour For You
    </h2>

    <div class="popular__all">
      @foreach($travel_packages as $travel_package)
      <article class="popular__card">
        <a href="{{ route('travel_package.show', $travel_package->slug) }}">
          <img src="{{ Storage::url($travel_package->galleries->first()->images) }}" alt="" class="popular__img" />
          <div class="popular__data">
            <h2 class="popular__price"><span>IDR</span>{{ number_format($travel_package->price,2) }}</h2>
            <h3 class="popular__title">{{ $travel_package->location }}</h3>
            <p class="popular__description">{{ $travel_package->type }}</p>
          </div>
        </a>
      </article>
      @endforeach
    </div>
  </div>
</section>

<!-- Modal Pembayaran -->
<div id="paymentModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Pilih Metode Pembayaran</h2>
    <form id="paymentForm">
      <div class="form-group">
        <label for="paymentMethod">Metode Pembayaran:</label>
        <select id="paymentMethod" name="paymentMethod" class="form-select" required>
          <option value="">---Pilih Bank---</option>
          <option value="bri">BRI</option>
          <option value="bank_jago">Bank Jago</option>
        </select>
      </div>
      
      <!-- Info Bank -->
      <div id="bankDetails" style="display: none;">
        <div id="bankInfo">
          <img id="bankLogo" src="" alt="Logo Bank" width="20%">
          <p id="bankAccount">Nomor Rekening: </p>
          <p id="accountOwner">Atas Nama: </p>
        </div>
      </div>
      
      <!-- Upload Bukti Pembayaran -->
      <div class="form-group">
        <label for="proofOfPayment">Upload Bukti Pembayaran:</label>
        <input type="file" id="proofOfPayment" name="proofOfPayment" class="form-control" required>
      </div>
      <button type="submit" class="button button-booking">Submit</button>
    </form>
  </div>
</div>

@if(session()->has('message'))
<div id="alert" class="alert">
  {{ session()->get('message') }}
  <i class='bx bx-x alert-close' id="close"></i>
</div>
@endif

@push('style-alt')
<style>
  /* CSS untuk modal */
  .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
  }

  .modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
  }

  .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }

  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }

  .alert {
    position: absolute;
    top: 120px;
    left: 0;
    right: 0;
    background-color: var(--second-color);
    color: white;
    padding: 1rem;
    width: 70%;
    z-index: 99;
    margin: auto;
    border-radius: .25rem;
    text-align: center;
  }

  .alert-close {
    font-size: 1.5rem;
    color: #090909;
    position: absolute;
    top: .25rem;
    right: .5rem;
    cursor: pointer;
  }

  blockquote {
    border-left: 8px solid #b4b4b4;
    padding-left: 1rem;
  }

  .blog__detail ul li {
    list-style: initial;
  }
</style>
@endpush

@push('script-alt')
<script>
  // Membuka modal pembayaran ketika tombol "Send" diklik
  document.getElementById('openPaymentModal').addEventListener('click', function() {
    document.getElementById('paymentModal').style.display = 'block';
  });

  // Menutup modal pembayaran ketika tombol close diklik
  document.querySelector('.close').addEventListener('click', function() {
    document.getElementById('paymentModal').style.display = 'none';
  });

  // Menampilkan informasi bank sesuai metode pembayaran yang dipilih
  document.getElementById('paymentMethod').addEventListener('change', function() {
    var selectedMethod = this.value;
    var bankDetails = document.getElementById('bankDetails');
    var bankLogo = document.getElementById('bankLogo');
    var bankAccount = document.getElementById('bankAccount');
    var accountOwner = document.getElementById('accountOwner');

    if (selectedMethod === 'bri') {
      bankDetails.style.display = 'block';
      bankLogo.src = 'https://i0.wp.com/febi.uinsaid.ac.id/wp-content/uploads/2020/11/Logo-BRI-Bank-Rakyat-Indonesia-PNG-Terbaru.png?ssl=1';
      bankAccount.textContent = 'Nomor Rekening: 1810530247';
      accountOwner.textContent = 'Atas Nama: Ahmad Robbiul Iman';
    } else if (selectedMethod === 'bank_jago') {
      bankDetails.style.display = 'block';
      bankLogo.src = 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c0/Logo-jago.svg/1280px-Logo-jago.svg.png';
      bankAccount.textContent = 'Nomor Rekening: 12345678';
      accountOwner.textContent = 'Atas Nama: Ahmad Robbiul Iman';
    } else {
      bankDetails.style.display = 'none';
    }
  });

  // Menutup alert pesan
  const close = document.getElementById('close');
  const alert = document.getElementById('alert');
  if (close) {
    close.addEventListener('click', function() {
      alert.style.display = 'none';
    });
  }
</script>
@endpush