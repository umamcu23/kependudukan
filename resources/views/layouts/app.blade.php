<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard Kependudukan')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Highcharts -->
    <script src="https://code.highcharts.com/maps/highmaps.js"></script>
    <script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <!-- Favicons -->
    <link sizes="16x16" href="{{ asset('assets/logo-kelompok11.png')}}" rel="icon">
    <link sizes="16x16" href="{{ asset('assets/logo-kelompok11.png')}}" rel="umaystory">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@600&family=Tangerine:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Lobster&family=Pacifico&family=Satisfy&family=Bree+Serif&family=Vollkorn&family=Great+Vibes&family=Lobster+Two&display=swap" rel="stylesheet">


    <!-- Vendor CSS Files -->
    <link href="https://umaystory.com/assets/vendor_landing/aos/aos.css" rel="stylesheet">
    <link href="https://umaystory.com/assets/vendor_landing/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://umaystory.com/assets/vendor_landing/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="https://umaystory.com/assets/vendor_landing/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="https://umaystory.com/assets/vendor_landing/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="https://umaystory.com/assets/vendor_landing/remixicon/remixicon.css" rel="stylesheet">
    <link href="https://umaystory.com/assets/vendor_landing/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">


    <style>
        body { background:#f6f7fb; }
        .chart { height: 360px; }

        /* FILTER CARD */
        .filter-card {
            border: none;
            border-radius: 14px;
            background: linear-gradient(135deg,#ffffff,#f8f9fc);
        }

        .filter-card label {
            font-size: .8rem;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: #6c757d;
        }

        .filter-card .form-select {
            border-radius: 10px;
            font-size: .9rem;
        }

        .filter-card button {
            border-radius: 10px;
        }

        .chart-card {
            border: none;
            border-radius: 16px;
            transition: all .3s ease;
        }

        .chart-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 25px rgba(0,0,0,.12);
        }

        .chart-card .card-header {
            background: none;
            border-bottom: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .chart-card .card-body {
            padding-top: 0;
        }

        .chart {
            height: 360px;
        }

        .container-fluid {
            padding-left: 24px;
            padding-right: 24px;
        }

        /* ===== KPI CARD ===== */
        .kpi-card {
            border: none;
            border-radius: 14px;
            transition: all .3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .kpi-card:hover {
            transform: translateY(-6px) scale(1.01);
            box-shadow: 0 12px 25px rgba(0,0,0,.15);
        }

        /* icon */
        .kpi-icon {
            font-size: 2.8rem;
            opacity: .2;
            position: absolute;
            right: 20px;
            bottom: 15px;
        }

        /* warna card */
        .bg-male {
            background: linear-gradient(135deg,#4e73df,#224abe);
            color: #fff;
        }

        .bg-female {
            background: linear-gradient(135deg,#e83e8c,#c2185b);
            color: #fff;
        }

        .bg-total {
            background: linear-gradient(135deg,#1cc88a,#13855c);
            color: #fff;
        }

        .bg-age {
            background: linear-gradient(135deg,#f6c23e,#dda20a);
            color: #fff;
        }

        .kpi-card h6,
        .kpi-card small {
            opacity: .9;
        }

        /* Modal harus di atas fullscreen Highcharts */
        .modal {
            z-index: 100000 !important;
        }

        .modal-backdrop {
            z-index: 99999 !important;
        }

        /* Turunkan priority fullscreen Highcharts */
        .highcharts-fullscreen {
            z-index: 1040 !important;
        }

        .highcharts-container {
            z-index: 1;
        }

    </style>
    <style>
    #dropdown-hover {
        color: rgba(255, 255, 255, 0.7);
    }

    #dropdown-hover:hover {
        color: white;
    }

    /* start of slider */
    .swiper-container {
        width: 100%;
        padding-bottom: 150px;
    }

    .swiper-slide {
        background-position: center;
        background-size: cover;
    }

    @media (min-width: 380px) and (max-width: 540px) {
        .swiper-container {
            padding-bottom: 50px;
        }
    }

    .swiper-slide-shadow-left,
    .swiper-slide-shadow-right,
    .swiper-button-next:after,
    .swiper-button-prev:after {
        font-size: 30px;
        color: white;
    }

    .swiper-button-next:hover,
    .swiper-button-prev:hover {
        box-shadow: drop-shadow(6px 10px 12px rgba(134, 133, 133, 1));
    }

    .swiper-3d .swiper-slide-shadow-left,
    .swiper-3d .swiper-slide-shadow-right {
        background-image: none;
    }

    /* end of slider */


    .button-link {
        background: #5c76ad;
        border-radius: 999px;
        box-shadow: #5c76ad 0 10px 20px -10px;
        box-sizing: border-box;
        color: #FFFFFF;
        cursor: pointer;
        font-family: Inter, Helvetica, "Apple Color Emoji", "Segoe UI Emoji", NotoColorEmoji, "Noto Color Emoji", "Segoe UI Symbol", "Android Emoji", EmojiSymbols, -apple-system, system-ui, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", sans-serif;
        font-size: 16px;
        font-weight: 700;
        line-height: 24px;
        opacity: 1;
        outline: 0 solid transparent;
        padding: 8px 18px;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        width: fit-content;
        word-break: break-word;
        border: 0;
    }

    .button-link:hover {
        background-color: rgb(48, 82, 254);
        color: #fff;
        font-weight: 600;
        cursor: pointer;
        box-shadow: rgba(0, 0, 0, 0.15) 0px 15px 25px, rgba(0, 0, 0, 0.05) 0px 5px 10px;
        transition: transform .5s ease-out;
        transform: translate(0, 13px);
        /* margin-top: 50px; */
    }
    
    /* Text Font */
    .text-vollkorn {
    font-family: 'Vollkorn';
    }

    .text-satisfy {
    font-family: 'Satisfy';
    }

    .text-great-vibes {
    font-family: 'Great Vibes';
    }


    .text-lobster-two {
    font-family: 'Lobster Two';
    }

    .text-fredoka {
    font-family: 'Fredoka';
    }

    .text-berkshire-swash {
    font-family: 'Berkshire Swash';
    }

    #genderTableContainer {
        width: 100% !important;
        padding: 10px;
        display: block;
        overflow-x: auto;
    }

    /* DataTables wrapper override */
    .dataTables_wrapper {
        width: 100% !important;
    }

    #genderTable {
        width: 100% !important;
    }

    /* Hilangkan padding modal */
    #genderModal .modal-body {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    /* =============================
   STICKY FLOATING FILTER CARD
   ============================= */
    .filter-card-floating {
        position: sticky;
        top: 80px; /* Jarak dari atas */
        z-index: 999;
        background: white;
        border-radius: 20px;
        padding: 15px 20px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        border: 1px solid #e5e7eb;
        backdrop-filter: blur(6px);
        transition: all .3s ease;
    }

    /* Efek hover */
    .filter-card-floating:hover {
        box-shadow: 0 8px 28px rgba(0,0,0,0.12);
    }

    /* Membuat card terlihat mengapung */
    .filter-card-floating {
        transform: translateZ(0);
    }

    /* ---- CUSTOM DROPDOWN FILTER ---- */

    .filter-select {
        appearance: none !important;
        -webkit-appearance: none !important;
        -moz-appearance: none !important;

        background-color: #fff;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 10px 14px;
        font-size: 14px;
        transition: all 0.25s ease;
        cursor: pointer;
        box-shadow: 0px 2px 4px rgba(0,0,0,0.04);
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%23888' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px;
        width: 100%;
    }

    .filter-select:hover {
        border-color: #2CAFFE;
        box-shadow: 0px 0px 8px rgba(44, 175, 254, 0.3);
    }

    .filter-select:focus {
        outline: none !important;
        border-color: #2CAFFE;
        box-shadow: 0px 0px 10px rgba(44, 175, 254, 0.4);
    }

    /* Hilangkan icon default dropdown */
    .filter-select::-ms-expand {
        display: none;
    }

    #btnFilter {
        background: linear-gradient(135deg, #2CAFFE, #1C8BDC);
        border: none;
        border-radius: 12px;
        transition: 0.25s;
    }

    #btnFilter:hover {
        transform: translateY(-2px);
        box-shadow: 0px 6px 14px rgba(44, 175, 254, 0.4);
    }

    #btnRefresh {
        border-radius: 12px;
        transition: 0.25s;
    }

    #btnRefresh:hover {
        transform: translateY(-2px);
        box-shadow: 0px 6px 14px rgba(0,0,0,0.1);
    }


    #genderTable tbody tr:hover {
        background-color: rgba(44,175,254,0.15) !important; /* warna hover */
    }


</style>
</head>
<body>

@include('partials.navbar')

<main class="container-fluid py-4">
    @yield('content')
</main>

<!-- ======= Footer ======= -->
<footer class="bg-white">
    <div class="container">
        <div class="text-center text-dark p-2">
            &copy; Copyright <strong><span>Kelompok 11</span></strong>. All Rights Reserved
        </div>
    </div>
</footer><!-- End Footer -->
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<!-- <div id="preloader"></div> --><!-- Vendor JS Files -->
<script src="https://umaystory.com/assets/vendor_landing/purecounter/purecounter.js"></script>
<script src="https://umaystory.com/assets/vendor_landing/aos/aos.js"></script>
<script src="https://umaystory.com/assets/vendor_landing/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://umaystory.com/assets/vendor_landing/glightbox/js/glightbox.min.js"></script>
<script src="https://umaystory.com/assets/vendor_landing/swiper/swiper-bundle.min.js"></script>
<script src="https://umaystory.com/assets/vendor_landing/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="https://umaystory.com/assets/js_landing/main.js"></script>

<script>
    const swiper = new Swiper('.swiper-container', {
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 'auto',
        loop: true,
        speed: 1000,
        autoplay: {
            delay: 3000,
        },

        coverflowEffect: {
            rotate: 10, //Rotasi kemiringan
            stretch: -50,
            depth: 300, //semakin besar yang tengah akan semakin besar juga
            modifier: 1,
            slideShadows: true,
        },

        breakpoints: {
            320: {
                slidesPerView: 2,
            },
            560: {
                slidesPerView: 3,
            },
            990: {
                slidesPerView: 4,
            }
        },

        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            dynamicBullets: true,
        },

        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<!-- DataTables -->
<!-- jQuery (wajib untuk DataTables) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>


<!-- DataTables Buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<!-- JSZip untuk export Excel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

@stack('scripts')
</body>
</html>
