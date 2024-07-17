@extends('layouts.frontend')

@section('content')
<!--==================== HOME ====================-->
<section>
  <div class="swiper-container gallery-top">
    <div class="swiper-wrapper">
      <!--========== ISLANDS 1 ==========-->
      <section class="islands swiper-slide">
        <img src="{{ asset('frontend/assets/img/contact-hero.jpg') }}" alt="" class="islands__bg" />
        <div class="bg__overlay">
          <div class="islands__container container">
            <div class="islands__data">
              <h2 class="islands__subtitle">Need Travel</h2>
              <h1 class="islands__title">Contact Us</h1>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</section>
<!--==================== CONTACT ====================-->
<section class="contact section" id="contact">
  <div class="contact__container container grid">
    <div class="contact__images">
      <div class="contact__orbe"></div>

      <div class="contact__img">
        <img src="{{ asset('frontend/assets/img/hdeh.jpg') }}" alt="" />
      </div>
    </div>

    <div class="contact__content">
      <div class="contact__data">
        <span class="section__subtitle">Need Help</span>
        <h2 class="section__title">Don't hesitate to contact us</h2>
        <p class="contact__description">
          Is there a problem finding places for yout next trip? Need a
          guide in first trip or need a consultation about traveling? just
          contact us.
        </p>
      </div>

      <div class="contact__card">
        <div class="contact__card-box">
          <div class="contact__card-info">
            <i><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M4 20q-.825 0-1.412-.587T2 18V6q0-.825.588-1.412T4 4h16q.825 0 1.413.588T22 6v12q0 .825-.587 1.413T20 20zm8-7l8-5V6l-8 5l-8-5v2z"/></svg></i>
            <div>
              <h3 class="contact__card-title">Email</h3>
              <p class="contact__card-description">lomboktourand<br/>travel@gmail.com</p>
            </div>
          </div>

          <button class="button contact__card-button">Mail Now</button>
        </div>
        <div class="contact__card-box">
          <div class="contact__card-info">
            <i class="bx bxs-message-rounded-dots"></i>
            <div>
              <h3 class="contact__card-title">Whatsapp</h3>
              <p class="contact__card-description">08771558927</p>
            </div>
          </div>

          <button class="button contact__card-button">Chat Now</button>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection