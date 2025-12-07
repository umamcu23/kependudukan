<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard Kependudukan')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css"> --}}

    <!-- Highcharts -->
    {{-- <script src="https://code.highcharts.com/highcharts.js"></script> --}}
    {{-- <script src="https://code.highcharts.com/modules/exporting.js"></script> --}}
    <script src="https://code.highcharts.com/maps/highmaps.js"></script>
    <script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>



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
</head>
<body>

@include('partials.navbar')

<main class="container-fluid py-4">
    @yield('content')
</main>
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
