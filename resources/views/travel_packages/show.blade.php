@extends('layouts.frontend')

@section('content')
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
          <form id="bookingForm">
            @csrf
            <input type="hidden" name="travel_package_id" value="{{ $travel_package->id }}">
            <input type="text" name="name" placeholder="Your Name" value="{{ $user->name }}" readonly />
            <input type="email" name="email" placeholder="Your Email" value="{{ $user->email }}" readonly />
            <input type="number" name="number_phone" placeholder="Your Number" required />
            <input placeholder="Pick Your Date" class="textbox-n" type="text" name="date" onfocus="(this.type='date')" id="date" />
            <a href="#" id="openPaymentModal" class="button button-booking">
              <center>Send</center>
            </a>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal Pembayaran -->
<div id="modalOverlay" class="overlay"></div>
<div id="paymentModal" class="modal">
  <div class="modal-header">
    <span class="close">&times;</span>
    <h1 class="text-white">{{ $gallery->name }}</h1>
  </div>
  <div class="modal-body">
    <div class="amount">
      <h2>Rp20.000</h2>
      <p>Order ID #Wisata-451</p>
    </div>
    <p>Pilih Metode Pembayaran</p>
    <div class="payment-methods">
      <h3>Nomor Rekening</h3>
      <div class="bank-icons">
        <div class="bank" data-account="123-456-7890" data-account-name="BCA" data-account-owner="Watoni">
          <img src="https://d2f3dnusg0rbp7.cloudfront.net/snap/v4/assets/bca-906e4db60303060666c5a10498c5a749962311037cf45e4f73866e9138dd9805.svg" alt="BCA">
        </div>
        <div class="bank" data-account="098-765-4321" data-account-name="Mandiri" data-account-owner="Watoni">
          <img src="https://d2f3dnusg0rbp7.cloudfront.net/snap/v4/assets/mandiri-23c931af42c624b4533ed48ac3020f2b820f20c7ad08fb9cf764140e5edbe496.svg" alt="Mandiri">
        </div>
        <div class="bank" data-account="567-890-1234" data-account-name="BNI" data-account-owner="Watoni">
          <img src="https://d2f3dnusg0rbp7.cloudfront.net/snap/v4/assets/bni-163d98085f5fe9df4068b91d64c50f5e5b347ca2ee306d27954e37b424ec4863.svg" alt="BNI">
        </div>
        <div class="bank" data-account="234-567-8901" data-account-name="BRI" data-account-owner="Watoni">
          <img src="https://d2f3dnusg0rbp7.cloudfront.net/snap/v4/assets/bri-39f5d44b1c42e70ad089fc52b909ef410d708d563119eb0da3a6abd49c4a595c.svg" alt="BRI">
        </div>
      </div>
    </div>
    <div class="account-number" id="accountNumber">
      Silakan pilih bank untuk menampilkan nomor rekening
      <i class="copy-icon" id="copyButton" onclick="copyToClipboard()" style="display:none; cursor:pointer;" title="Copy to clipboard">📋</i>
    </div>
    <div class="upload-button">
      <label for="proofOfPayment">Upload Bukti Pembayaran:</label>
      <input type="file" id="proofOfPayment" name="proofOfPayment" class="form-control" required accept="image/*">
      <center>
        <img id="previewImage" style="display:none; margin-top:10px; max-width:20%;" alt="Preview Image" />
      </center>
    </div>
  </div>
  <div class="modal-footer">
    <button type="submit" id="submitBooking" class="button button-booking">Submit</button>
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
  .overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
  }

  .modal {
    max-width: 600px;
    margin: 50px auto;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1000;
  }

  .modal-header {
    background-color: #1a3a6e;
    color: white;
    padding: 10px;
    border-radius: 8px 8px 0 0;
    display: flex;
    justify-content: flex-start;
    /* Posisi tombol close */
    align-items: center;
  }

  .modal-header h1 {
    flex: 1;
    /* Agar teks berada di tengah */
    text-align: center;
    margin: 0;
    color: white;
  }

  .modal-body,
  .modal-footer {
    padding: 20px;
  }

  .amount {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
  }

  .amount h2 {
    margin: 0;
    font-size: 24px;
  }

  .amount p {
    margin: 0;
    font-size: 14px;
    text-align: right;
    /* Teks di sebelah kanan */
  }

  .amount a {
    color: #1a3a6e;
    text-decoration: none;
  }

  .close {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    margin-right: 10px;
    /* Jarak sedikit antara tombol dan tepi kiri */
  }

  .close:hover {
    color: black;
  }

  .account-number {
    text-align: center;
    margin-top: 20px;
    font-weight: bold;
    /* Jadikan teks tebal */
  }

  .copy-icon {
    font-size: 18px;
    margin-left: 10px;
  }

  .upload-button {
    text-align: center;
    margin-top: 20px;
  }

  .bank-icons {
    display: flex;
    justify-content: space-around;
    margin: 20px 0;
  }

  .bank img {
    width: 50px;
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
</style>
@endpush

<script>
  document.getElementById('openPaymentModal').addEventListener('click', function() {
    document.getElementById('paymentModal').style.display = 'block';
    document.getElementById('modalOverlay').style.display = 'block';
  });

  function closeModal() {
    document.getElementById('paymentModal').style.display = 'none';
    document.getElementById('modalOverlay').style.display = 'none';
  }

  document.querySelector('.close').addEventListener('click', closeModal);
  document.getElementById('modalOverlay').addEventListener('click', closeModal);

  const bankIcons = document.querySelectorAll('.bank');
  const accountNumberDisplay = document.getElementById('accountNumber');

  bankIcons.forEach(icon => {
    icon.addEventListener('click', function() {
      const accountInfo = this.getAttribute('data-account');
      accountNumberDisplay.textContent = accountInfo;
      accountNumberDisplay.style.display = 'block';
    });
  });

  document.getElementById('proofOfPayment').addEventListener('change', function() {
    const file = this.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        const previewImage = document.getElementById('previewImage');
        previewImage.src = e.target.result;
        previewImage.style.display = 'block';
      };
      reader.readAsDataURL(file);
    }
  });

  document.getElementById('submitBooking').addEventListener('click', function(e) {
    e.preventDefault();

    let formData = new FormData(document.getElementById('bookingForm'));
    const proofOfPayment = document.getElementById('proofOfPayment').files[0];
    formData.append('proofOfPayment', proofOfPayment);

    fetch('{{ route('booking.store') }}', {
          method: 'POST',
          body: formData,
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          }
        })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        // Menggunakan SweetAlert untuk menampilkan pesan sukses
        swal("Success!", data.message, "success");
        closeModal();
      })
      .catch(error => {
        console.error('Error:', error);
        // Menggunakan SweetAlert untuk menampilkan pesan error
        swal("Error!", "Terjadi kesalahan saat membuat booking.", "error");
      });
  });

  const closeAlertButton = document.getElementById('close');
  const alertBox = document.getElementById('alert');

  if (closeAlertButton) {
    closeAlertButton.addEventListener('click', function() {
      alertBox.style.display = 'none';
    });
  }
</script>