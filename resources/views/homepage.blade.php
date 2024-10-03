@extends('layouts.frontend')

@section('content')
<style>
    .modal-custom {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        /* tambahkan z-index yang lebih tinggi */
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
</style>
<!--==================== HOME ====================-->
<section>
    <div class="swiper-container">
        <div>
            <!--========== ISLANDS 1 ==========-->
            <section class="islands">
                <img
                    src="{{ asset('frontend/assets/img/hero.jpg') }}"
                    alt=""
                    class="islands__bg" />
                <div class="bg__overlay">
                    <div class="islands__container container">
                        <div
                            class="islands__data"
                            style="z-index: 99; position: relative">
                            <h2 class="islands__subtitle">
                                Explore
                            </h2>
                            <h1 class="islands__title">
                                Wonderfull Lombok
                            </h1>
                            <p class="islands__description">
                                It's the perfect time travel and
                                enjoy the <br />
                                beauty of the world.
                            </p>
                            <button class="button nav__button" id="cari-tiket">Cari Tiket</button>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>

<!--==================== LOGOS ====================-->
<section
    class="logos"
    style="margin-top: 9rem; padding-bottom: 3rem">
    <div class="logos__container container grid">
        <div class="logos__img">
            <img src="{{ asset('frontend/assets/img/tripadvisor.png') }}" alt="" />
        </div>
        <div class="logos__img">
            <img src="{{ asset('frontend/assets/img/airbnb.png') }}" alt="" />
        </div>
        <div class="logos__img">
            <img src="{{ asset('frontend/assets/img/booking.png') }}" alt="" />
        </div>
        <div class="logos__img">
            <img src="{{ asset('frontend/assets/img/airasia.png') }}" alt="" />
        </div>
    </div>
</section>

<!--==================== POPULAR ====================-->
<section class="section" id="popular">
    <div class="container">
        <span class="section__subtitle" style="text-align: center">Best Choice</span>
        <h2 class="section__title" style="text-align: center">
            Popular Places
        </h2>

        <div class="popular__container swiper">
            <div class="swiper-wrapper">
                @foreach($travel_packages as $travel_package)
                <article class="popular__card swiper-slide">
                    <a href="{{ route('travel_package.show', $travel_package->slug) }}">
                        <img
                            src="{{ Storage::url($travel_package->galleries->first()->images) }}"
                            alt=""
                            class="popular__img" />
                        <div class="popular__data">
                            <h2 class="popular__price">
                                <span>Rp.</span>{{ number_format($travel_package->price,2) }}
                            </h2>
                            <h3 class="popular__title">
                                {{ $travel_package->location}}
                            </h3>
                            <p class="popular__description">{{ $travel_package->type }}</p>
                        </div>
                    </a>
                </article>
                @endforeach
            </div>

            <div class="swiper-button-next">
                <i class="bx bx-chevron-right"></i>
            </div>
            <div class="swiper-button-prev">
                <i class="bx bx-chevron-left"></i>
            </div>
        </div>
    </div>
</section>

<!--==================== Rinjani Montain ====================-->
<section class="section" id="popular">
    <div class="container">
        <span class="section__subtitle" style="text-align: center">Best Choice</span>
        <h2 class="section__title" style="text-align: center">
            Rinjani Montain Package
        </h2>

        <div class="popular__container swiper">
            <div class="swiper-wrapper">
                @foreach($rinjani as $rinjanis)
                <article class="popular__card swiper-slide">
                    <a href="{{ route('travel_package.show', $rinjanis->slug) }}">
                        <img
                            src="{{ Storage::url($rinjanis->galleries->first()->images) }}"
                            alt=""
                            class="popular__img" />
                        <div class="popular__data">
                            <h2 class="popular__price">
                                <span>Rp.</span>{{ number_format($rinjanis->price,2) }}
                            </h2>
                            <h3 class="popular__title">
                                {{ $rinjanis->location}}
                            </h3>
                            <p class="popular__description">{{ $rinjanis->type }}</p>
                        </div>
                    </a>
                </article>
                @endforeach
            </div>

            <div class="swiper-button-next">
                <i class="bx bx-chevron-right"></i>
            </div>
            <div class="swiper-button-prev">
                <i class="bx bx-chevron-left"></i>
            </div>
        </div>
    </div>
</section>

<!--==================== VALUE ====================-->
<section class="value section" id="value">
    <div class="value__container container grid">
        <div class="value__images">
            <div class="value__orbe"></div>

            <div class="value__img">
                <img src="{{ asset('frontend/assets/img/Pemandangan-Pantai-Tanjung-Bloam.jpg') }}" alt="" />
            </div>
        </div>

        <div class="value__content">
            <div class="value__data">
                <span class="section__subtitle">Why Choose Us</span>
                <h2 class="section__title">
                    Experience That We Promise To You
                </h2>
                <p class="value__description">
                    We always ready to serve by providing the best
                    service for you. We make a good choices to
                    travel around the world.
                </p>
            </div>

            <div class="value__accordion">
                <div class="value__accordion-item">
                    <header class="value__accordion-header">
                        <i
                            class="bx bxs-shield-x value-accordion-icon"></i>
                        <h3 class="value__accordion-title">
                            Best places in the world
                        </h3>
                        <div class="value__accordion-arrow">
                            <i class="bx bxs-down-arrow"></i>
                        </div>
                    </header>

                    <div class="value__accordion-content">
                        <p class="value__accordion-description">
                            We provides the best places around the
                            world and have a good quality of
                            service.
                        </p>
                    </div>
                </div>
                <div class="value__accordion-item">
                    <header class="value__accordion-header">
                        <i
                            class="bx bxs-x-square value-accordion-icon"></i>
                        <h3 class="value__accordion-title">
                            Affordable price for you
                        </h3>
                        <div class="value__accordion-arrow">
                            <i class="bx bxs-down-arrow"></i>
                        </div>
                    </header>

                    <div class="value__accordion-content">
                        <p class="value__accordion-description">
                            We try to make your budget fit with the
                            destination that you want to go.
                        </p>
                    </div>
                </div>
                <div class="value__accordion-item">
                    <header class="value__accordion-header">
                        <i
                            class="bx bxs-bar-chart-square value-accordion-icon"></i>
                        <h3 class="value__accordion-title">
                            Best plan for your time
                        </h3>
                        <div class="value__accordion-arrow">
                            <i class="bx bxs-down-arrow"></i>
                        </div>
                    </header>

                    <div class="value__accordion-content">
                        <p class="value__accordion-description">
                            Provides you with time properly.
                        </p>
                    </div>
                </div>
                <div class="value__accordion-item">
                    <header class="value__accordion-header">
                        <i
                            class="bx bxs-check-square value-accordion-icon"></i>
                        <h3 class="value__accordion-title">
                            Security guarantee
                        </h3>
                        <div class="value__accordion-arrow">
                            <i class="bx bxs-down-arrow"></i>
                        </div>
                    </header>

                    <div class="value__accordion-content">
                        <p class="value__accordion-description">
                            We make sure that our services have a
                            good of security
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- blog -->
<section class="blog section" id="blog">
    <div class="blog__container container">
        <span class="section__subtitle" style="text-align: center">Our Blog</span>
        <h2 class="section__title" style="text-align: center">
            The Best Trip For You
        </h2>

        <div class="blog__content grid">
            @foreach($blogs as $blog)
            <article class="blog__card">
                <div class="blog__image">
                    <img
                        src="{{ Storage::url($blog->image) }}"
                        alt=""
                        class="blog__img" />
                    <a href="{{ route('blog.show', $blog->slug) }}" class="blog__button">
                        <i class="bx bx-right-arrow-alt"></i>
                    </a>
                </div>

                <div class="blog__data">
                    <h2 class="blog__title">
                        {{ $blog->title }}
                    </h2>
                    <p class="blog__description">
                        {{ $blog->excerpt }}
                    </p>

                    <div class="blog__footer">
                        <div class="blog__reaction">
                            {{ date('d M Y', strtotime($blog->created_at)) }}
                        </div>
                        <div class="blog__reaction">
                            <i class="bx bx-show"></i>
                            <span>{{ $blog->reads }}</span>
                        </div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

<!-- Modal -->
<!-- Modal -->
<div id="searchTicketModal" class="modal-custom">
    <div class="modal-content-custom">
        <div class="modal-header-custom">
            <h5 class="modal-title-custom">Cari Tiket</h5>
            <button type="button" class="close-custom" id="close-modal">&times;</button>
        </div>
        <div class="modal-body-custom">
            <form>
                <div class="form-group mb-3">
                    <label for="from">Dari</label>
                    <select class="form-control" id="from">
                        <option value="">Pilih Pelabuhan Keberangkatan</option>
                        @foreach($ports as $port)
                        <option value="{{ $port->id }}">{{ $port->port_from_id }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="to">Tujuan</label>
                    <select class="form-control" id="to">
                        <option value="">Pilih Pelabuhan Tujuan</option>
                        @foreach($ports as $port)
                        <option value="{{ $port->id }}">{{ $port->port_to_id }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="departure_date">Tanggal Keberangkatan</label>
                    <input type="date" class="form-control" id="departure_date" required>
                </div>
                <div class="form-group mb-3">
                    <label for="return_date">Tanggal Kembali</label>
                    <input type="checkbox" id="return_checkbox" />
                    <input type="date" class="form-control" id="return_date" disabled>
                </div>
            </form>
        </div>
        <div class="modal-footer-custom">
            <button type="button" class="btn btn-secondary" id="batal-modal">Batal</button>
            <button type="submit" class="button nav__button">Cari</button>
        </div>
    </div>
</div>

<!-- JavaScript to enable/disable return date input -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#cari-tiket').on('click', function() {
            $('#searchTicketModal').fadeIn();
        });
        $('#close-modal, #batal-modal').on('click', function() {
            $('#searchTicketModal').fadeOut();
        });
        $('#return_checkbox').on('change', function() {
            if ($(this).is(':checked')) {
                $('#return_date').prop('disabled', false);
            } else {
                $('#return_date').prop('disabled', true);
            }
        });
    });
</script>
@endsection