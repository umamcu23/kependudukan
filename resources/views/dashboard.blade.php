@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid mt-4 filter-card-floating">

    <!-- Filter Active Info -->
    <div id="activeFilterInfo" class="mb-3" style="display: none;">
        <div class="alert alert-info py-2 px-3 shadow-sm">
            <strong>Filter Aktif:</strong>
            <span id="badgeGender" class="badge bg-primary me-1"></span>
            <span id="badgeUmur" class="badge bg-success me-1"></span>
            <span id="badgeProvinsi" class="badge bg-warning text-dark me-1"></span>
        </div>
    </div>

    <div class="card shadow-sm border-0 filter-card ">
        <div class="card-body">
            <div class="row g-3 align-items-end">

                <!-- Jenis Kelamin -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-gender-ambiguous me-1 text-primary"></i> Jenis Kelamin
                    </label>
                    <select id="filterGender" class="filter-select">
                        <option value="">Semua</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>

                <!-- Umur -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-people-fill me-1 text-success"></i> Kelompok Umur
                    </label>
                    <select id="filterAge" class="filter-select">
                        <option value="">Semua</option>
                        <option value="00-04">00-04</option>
                        <option value="05-09">05-09</option>
                        <option value="10-14">10-14</option>
                        <option value="15-19">15-19</option>
                        <option value="20-24">20-24</option>
                        <option value="25-29">25-29</option>
                        <option value="30-34">30-34</option>
                        <option value="35-39">35-39</option>
                        <option value="40-44">40-44</option>
                        <option value="45-49">45-49</option>
                        <option value="50-54">50-54</option>
                        <option value="55-59">55-59</option>
                        <option value="60-64">60-64</option>
                        <option value="65-69">65-69</option>
                        <option value="70-74">70-74</option>
                        <option value="75-79">75-79</option>
                        <option value="80-84">80-84</option>
                        <option value="85-89">85-89</option>
                        <option value="90-94">90-94</option>
                        <option value="95+">95+</option>
                    </select>
                </div>

                <!-- Provinsi -->
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-geo-alt-fill me-1 text-danger"></i> Provinsi
                    </label>
                    <select id="filterProvince" class="filter-select">
                        <option value="">Semua</option>
                        @foreach($provinsi as $p)
                            <option value="{{ $p }}">{{ $p }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Button -->
                <div class="col-md-1 d-grid gap-2">
                    <button id="btnFilter" class="btn btn-primary btn-sm shadow-sm">
                        <i class="bi bi-funnel-fill"></i>
                    </button>

                    <button id="btnRefresh" class="btn btn-outline-secondary btn-sm shadow-sm">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-3">
    <div class="row g-3">

        <!-- TOTAL LAKI-LAKI & PEREMPUAN -->
        <div class="col-md-4">
            <div class="card kpi-card bg-male h-100">
                <div class="card-body">
                    <h6>Total Penduduk Laki-laki</h6>
                    <h2 class="fw-bold" id="totalL"></h2>

                    <hr class="border-white opacity-25">

                    <h6>Total Penduduk Perempuan</h6>
                    <h2 class="fw-bold" id="totalP"></h2>

                    <i class="bi bi-gender-ambiguous kpi-icon"></i>
                </div>
            </div>
        </div>

        <!-- TOTAL PENDUDUK -->
        <div class="col-md-4">
            <div class="card kpi-card bg-total h-100 text-center">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h6>Total Penduduk Indonesia</h6>
                    <h1 class="fw-bold" id="totalPenduduk"></h1>
                    <small id="totalPendudukLabel">
                        Semua Provinsi • Semua Umur • Semua Gender
                    </small>

                    <i class="bi bi-people-fill kpi-icon"></i>
                </div>
            </div>
        </div>

        <!-- UMUR TERBANYAK -->
        <div class="col-md-4">
            <div class="card kpi-card bg-age h-100">
                <div class="card-body">
                    <h6>Kelompok Umur Terbanyak</h6>
                    <h2 class="fw-bold" id="umurTerbanyak"></h2>

                    <p class="mb-0">
                        Total:
                        <strong id="umurTotal"></strong> orang
                    </p>

                    <i class="bi bi-bar-chart-fill kpi-icon"></i>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-xl-12 mb-3">
           <div class="card chart-card shadow-sm">
                <div class="card-header">
                    <i class="bi bi-gender-ambiguous text-primary"></i>
                    Penduduk berdasarkan peta Indonesia
                </div>
                <div class="card-body">
                    <div id="provinsiMap" style="height: 500px;"></div>
                </div>
            </div>
        </div>

         <div class="col-xl-12 mb-3">
            <div class="card chart-card shadow-sm">
                <div class="card-header">
                    <i class="bi bi-geo-alt-fill text-success"></i>
                    Penduduk per Provinsi
                </div>
                <div class="card-body">
                    <div id="provinsiChart" class="chart"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 mb-3">
           <div class="card chart-card shadow-sm">
                <div class="card-header">
                    <i class="bi bi-gender-ambiguous text-primary"></i>
                    Penduduk Berdasarkan Jenis Kelamin
                </div>
                <div class="card-body">
                    <div id="genderChart" class="chart"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 mb-3">
            <div class="card chart-card shadow-sm h-100">
                <div class="card-header d-flex align-items-center gap-2">
                    <i class="bi bi-bar-chart-line-fill text-primary"></i>
                    <span class="fw-semibold">Penduduk Berdasarkan Umur</span>
                </div>
                <div class="card-body">
                    <div id="umurGenderLineChart" class="chart"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 mb-3 d-none">
           <div class="card chart-card shadow-sm">
                <div class="card-header">
                    <i class="bi bi-graph-up-arrow text-info"></i>
                    Trend Penduduk
                </div>
                <div class="card-body">
                    <div id="trendChart" class="chart"></div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal Detail Gender / Provinsi -->
<div class="modal fade" id="genderModal" tabindex="-1" aria-labelledby="genderModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="genderModalTitle">Detail Penduduk</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

       
        <div class="mb-3 d-flex justify-content-between align-items-center px-2">
            <span id="genderTotalPenduduk" class="fw-bold fs-5">0 orang</span>
        </div>

        <div class="table-responsive">
            <div id="genderTableContainer" style="overflow-x:auto; white-space:nowrap;">
            <table id="genderTable" class="table table-striped table-hover table-bordered nowrap" style="width:100%">
                <thead>
                <!-- JS akan generate -->
                </thead>
                <tbody>
                <!-- JS akan generate -->
                </tbody>
            </table>
            </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>



@endsection

@push('scripts')


<script>
let genderTable = null;
let genderModalInstance = null;

function clearFilter(){
    $('#filterGender').val('').trigger('change');
    $('#filterAge').val('').trigger('change');
    $('#filterProvince').val('').trigger('change');    
}


function loadDashboard() {
    fetchJson('/dashboard/data/summary?' + queryParamsCommon())
        .then(renderGenderChart);
    loadKpi();
    renderProvinsiChart();
    renderTrendChart();
    renderUmurGenderLineChart();
    renderProvinsiMap();
}

// function loadSummary(){
    fetch('/dashboard/data/summary')
    .then(res => res.json())
    .then(data => {
    
        let totalL = 0;
        let totalP = 0;
    
        data.forEach(item => {
            if (item.jenis_kelamin === 'L') {
                totalL = Number(item.total);
            }
            if (item.jenis_kelamin === 'P') {
                totalP = Number(item.total);
            }
        });
    
        animateNumber('totalL', totalL);
        animateNumber('totalP', totalP);
    
        animateNumber('totalPenduduk', totalL + totalP); // ✅ numeric
    });

    fetch('/dashboard/data/by-umur')
    .then(res => res.json())
    .then(data => {
    
        const grouped = {};
    
        data.forEach(d => {
            grouped[d.umur] = (grouped[d.umur] || 0) + Number(d.total);
        });
    
        let maxUmur = null;
        let maxVal = 0;
    
        Object.keys(grouped).forEach(umur => {
            if (grouped[umur] > maxVal) {
                maxVal = grouped[umur];
                maxUmur = umur;
            }
        });
    
        document.getElementById('umurTerbanyak').textContent = maxUmur;
        animateNumber('umurTotal', maxVal);
    });
// }

/* ==============================
   GLOBAL FETCH OPTIONS
================================ */
const fetchJson = (url) =>
    fetch(url, {
        headers: { 'Accept': 'application/json' }
    }).then(r => r.json());


/* ==============================
   PIE CHART – JENIS KELAMIN
================================ */
function renderGenderChart(data) {
    Highcharts.chart('genderChart', {
        chart: { type: 'pie' },
        title: { text: null },

        plotOptions: {
            pie: {
                innerSize: '50%',
                cursor: 'pointer',

                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b><br>{point.y:,.0f} ({point.percentage:.1f}%)'
                },

                point: {
                    events: {
                        click: function () {
                            loadGenderDetail(this.gender_code, this.name);
                        }
                    }
                }
            }
        },

        series: [{
            name: 'Penduduk',
            data: data.map(d => ({
                name: d.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
                y: Number(d.total),
                gender_code: d.jenis_kelamin
            }))
        }]
    });
}

/* ==============================
   PROVINSI
================================ */
function renderProvinsiChart() {
    const jenisKelaminFilter = document.querySelector('#filterGender').value || '';
    const umurFilter = document.querySelector('#filterAge').value || '';
    const provinsiFilter = document.querySelector('#filterProvince').value || '';

    // Kirim semua filter ke backend
    const params = new URLSearchParams({
        jenis_kelamin: jenisKelaminFilter,
        umur: umurFilter,
        provinsi: provinsiFilter
    }).toString();

    fetchJson('/dashboard/data/by-provinsi?' + params)
        .then(data => {

            // Sort ASC
            data.sort((a, b) => a.provinsi.localeCompare(b.provinsi, 'id'));

            Highcharts.chart('provinsiChart', {
                chart: { type: 'column' },
                title: { text: null },

                xAxis: {
                    categories: data.map(d => d.provinsi),
                    labels: { rotation: -45 }
                },

                yAxis: {
                    title: { text: 'Jumlah Penduduk' }
                },

                tooltip: { pointFormat: '<b>{point.y:,.0f}</b> orang' },

                plotOptions: {
                    series: {
                        dataLabels: {
                            enabled: true,
                            format: '{y:,.0f}',
                            style: { fontWeight: 'bold', color: '#333' }
                        }
                    },
                    column: {
                        cursor: 'pointer',
                        point: {
                            events: {
                                click: function () {
                                    loadProvinsiDetail(
                                        this.category,
                                        jenisKelaminFilter,
                                        umurFilter,
                                        this.name
                                    );
                                }
                            }
                        }
                    }
                },

                series: [{
                    name: 'Penduduk',
                    data: data.map(d => ({
                        name: d.provinsi,
                        y: Number(d.total),
                        gender_code: d.jenis_kelamin
                    }))
                }]
            });
        });
}

/* ==============================
   TREND LINE
================================ */
function renderTrendChart() {
    fetchJson('/dashboard/data/trend?' + queryParamsCommon())
    .then(data => {
        Highcharts.chart('trendChart', {
            chart: { type:'line' },
            title: { text: null },
            xAxis: { categories: data.map(d => d.tahun) },
            series: [{
                name:'Jumlah Penduduk',
                data: data.map(d => Number(d.total))
            }]
        });
    });
}

function queryParamsCommon() {
    const gender = document.querySelector('#filterGender').value || '';
    const umur = document.querySelector('#filterAge').value || '';
    const prov = document.querySelector('#filterProvince').value || '';

    const params = new URLSearchParams();

    if (gender) params.append('jenis_kelamin', gender);
    if (umur) params.append('umur', umur);
    if (prov) params.append('provinsi', prov);

    return params.toString();
}


function queryParamsMap() {
    const params = new URLSearchParams();

    // ✅ MAP HANYA IKUT FILTER YANG MASUK AKAL
    if (filterGender.value)
        params.append('jenis_kelamin', filterGender.value);

    if (filterAge.value)
        params.append('umur', filterAge.value);

    return params.toString();
}


loadDashboard();  
btnFilter.addEventListener('click', function() {
    onFilterChange();  // update label
     // reload chart / KPI sesuai filter
    loadDashboard();  
});



/* ==============================
   MODAL + DATATABLE
================================ */

function loadGenderDetail(gender, title) {
    document.getElementById('genderModalTitle').innerText =
        `Detail Penduduk - ${title}`;

    // destroy DataTable kalau ada
    resetGenderTable();


    fetch(`/dashboard/data/detail-gender-pivot/${gender}?${queryParamsCommon()}`)
        .then(res => res.json())
        .then(res => {

            // HITUNG TOTAL
            let total = 0;
            res.data.forEach(row => {
                res.umur.forEach(u => {
                    total += Number(row[u] || 0);
                });
            });
            document.getElementById('genderTotalPenduduk').innerText =
                total.toLocaleString('id-ID') + " orang";

            // HEADER
            let thead = `
                <tr>
                    <th width="5%">No</th>
                    <th>Provinsi</th>
                    <th>Jenis Kelamin</th>
            `;
            res.umur.forEach(u => {
                thead += `<th class="text-end">${u}</th>`;
            });
            thead += `</tr>`;

            // BODY
            let tbody = '';
            res.data.forEach((row, i) => {
                tbody += `
                    <tr>
                        <td>${i + 1}</td>
                        <td>${row.provinsi}</td>
                        <td>${row.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'}</td>
                `;
                res.umur.forEach(u => {
                    tbody += `
                        <td class="text-end">
                            ${Number(row[u] || 0).toLocaleString('id-ID')}
                        </td>`;
                });
                tbody += `</tr>`;
            });

            document.querySelector('#genderTable thead').innerHTML = thead;
            document.querySelector('#genderTable tbody').innerHTML = tbody;

            // Inisialisasi DataTable (pakai jQuery DataTables API)
            // Pastikan kamu sudah include DataTables + Buttons + Responsive libs
            genderTable = $('#genderTable').DataTable({
                destroy: true,
                scrollX: true,
                scrollCollapse: true,
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,        // penting untuk mencegah perhitungan width otomatis yang salah
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copyHtml5', title: `Detail Penduduk - ${title}` },
                    { extend: 'excelHtml5', title: `Detail Penduduk - ${title}` },
                    { extend: 'csvHtml5', title: `Detail Penduduk - ${title}` },
                    {
                        extend: 'pdfHtml5',
                        title: `Detail Penduduk - ${title}`,
                        orientation: 'landscape',
                        pageSize: 'A4'
                    },
                    { extend: 'print', title: `Detail Penduduk - ${title}` }
                ],
                columnDefs: [
                    { className: 'text-end', targets: res.umur.length ? Array.from({length: res.umur.length}, (_,i)=>i+3) : [] }
                    // note: targets here are indexes of umur columns (adjust if needed)
                ]
            });

            // Buka modal (satu instance bootstrap)
            if (!genderModalInstance) {
                genderModalInstance = new bootstrap.Modal(document.getElementById('genderModal'), {
                    backdrop: true,
                    keyboard: true
                });
            }
            genderModalInstance.show();
        });
}

// Pastikan DataTables men-adjust kolom setelah modal benar-benar tampil
$('#genderModal').on('shown.bs.modal', function () {
    // kalau genderTable sudah inisialisasi, paksa adjust + responsive recalc + draw
    if (genderTable && typeof genderTable.columns === 'function') {
        // delay kecil untuk memastikan layout DOM stabil
        setTimeout(function () {
            try {
                genderTable.columns.adjust();
                if (genderTable.responsive && typeof genderTable.responsive.recalc === 'function') {
                    genderTable.responsive.recalc();
                }
                genderTable.draw(false); // false -> tidak ubah page
            } catch (e) {
                // fallback: jika instance berbeda (DataTables 2.x / new DataTable), coba alternatif:
                try {
                    // for new DataTable() API
                    const dtApi = $('#genderTable').DataTable();
                    dtApi.columns.adjust();
                    if (dtApi.responsive) dtApi.responsive.recalc();
                    dtApi.draw(false);
                } catch (err) {
                    console.warn('Columns adjust failed', err);
                }
            }
        }, 50); // 50ms cukup di kebanyakan kasus
    }
});



function showGenderModal() {
    const el = document.getElementById('genderModal');

    if (!genderModalInstance) {
        genderModalInstance = new bootstrap.Modal(el, {
            backdrop: 'static',
            keyboard: true
        });
    }

    genderModalInstance.show();

    // Inisialisasi DataTable jika belum
    if (!$.fn.DataTable.isDataTable('#genderTable')) {
        genderTable = $('#genderTable').DataTable({
            scrollX: true,
            scrollY: '50vh',
            scrollCollapse: true,
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            dom: 'Bfrtip', // tombol akan muncul
            buttons: [
                { extend: 'copyHtml5', title: `Detail Penduduk - ${title}` },
                { extend: 'excelHtml5', title: `Detail Penduduk - ${title}` },
                { extend: 'csvHtml5', title: `Detail Penduduk - ${title}` },
                {
                    extend: 'pdfHtml5',
                    title: `Detail Penduduk - ${title}`,
                    orientation: 'landscape',
                    pageSize: 'A4'
                },
                { extend: 'print', title: `Detail Penduduk - ${title}` }
            ],
            columnDefs: [
                { className: 'text-end', targets: '_all' }
            ]
        });
    } else {
        genderTable.draw();
    }

}


function loadKpi() {
    fetchJson('/dashboard/data/kpi?' + queryParamsCommon())
    .then(res => {
        document.getElementById('totalL').innerText =
            Number(res.laki_laki).toLocaleString();

        document.getElementById('totalP').innerText =
            Number(res.perempuan).toLocaleString();

        document.getElementById('totalPenduduk').innerText =
            Number(res.total).toLocaleString();

        if (res.umur_terbanyak) {
            document.getElementById('umurTerbanyak').innerText =
                res.umur_terbanyak.umur;

            document.getElementById('umurTotal').innerText =
                Number(res.umur_terbanyak.total).toLocaleString();
        }

        
        // Misal filter aktif
        const filters = {
            // umur: getFilterUmur(),          // function ambil value select umur
            // gender: getFilterGender()       // function ambil value select gender
        };

        // total sesuai filter
        let totalPenduduk = res.total;
        if (filters.gender === 'L') totalPenduduk = res.laki_laki;
        if (filters.gender === 'P') totalPenduduk = res.perempuan;

        // updateTotalPendudukKPI(filters, totalPenduduk);
    });
}

function resetGenderTable() {

    // Destroy jika sudah jadi DataTable
    if ($.fn.DataTable.isDataTable('#genderTable')) {
        $('#genderTable').DataTable().clear().destroy();
    }

    // Hapus wrapper DataTables (penting!)
    $('#genderTable').closest('.dataTables_wrapper').remove();

    // Rebuild tabel kosong
    document.getElementById('genderTableContainer').innerHTML = `
        <table id="genderTable" class="table table-bordered table-striped w-auto">
            <thead></thead>
            <tbody></tbody>
        </table>
    `;
}


/**
 * Animate Number (Count Up)
 * @param elementId
 * @param endValue
 * @param duration (ms)
 */
function animateNumber(elementId, endValue, duration = 1000) {
    const el = document.getElementById(elementId);
    if (!el) return;

    const startValue = 0;
    const startTime = performance.now();

    function update(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);

        const currentValue = Math.floor(progress * endValue);
        el.textContent = currentValue.toLocaleString('id-ID');

        if (progress < 1) {
            requestAnimationFrame(update);
        }
    }

    requestAnimationFrame(update);
}

document.getElementById('btnRefresh').addEventListener('click', () => {
    clearFilter(); // reset select filter ke default
    updateTotalPendudukLabel({ provinsi: null, umur: null, gender: null }); // reset label
    loadDashboard(); // reload chart / KPI
});

let provinsiTable = null;
function loadProvinsiDetail(provinsi, jenisKelaminFilter, umurFilter, title) {
    document.getElementById('genderModalTitle').innerText =
        `Detail Penduduk - ${title}`;

    resetGenderTable();

    const params = new URLSearchParams({
        provinsi: provinsi,
        jenis_kelamin: jenisKelaminFilter || '',
        umur: umurFilter || ''
    }).toString();

    fetch(`/dashboard/data/detail-provinsi-pivot/${encodeURIComponent(provinsi)}?${params}`)
        .then(res => res.json())
        .then(res => {

            // ======================
            // FILTER UMUR & GENDER
            // ======================
            let umurList = res.umur;
            if (umurFilter) {
                umurList = umurList.filter(u => u === umurFilter);
            }

            let dataRows = res.data;
            if (jenisKelaminFilter) {
                dataRows = dataRows.filter(r => r.jenis_kelamin === jenisKelaminFilter);
            }

            // ======================
            // HITUNG TOTAL
            // ======================
            let total = 0;
            dataRows.forEach(row => {
                umurList.forEach(u => {
                    total += Number(row[u] || 0);
                });
            });
            document.getElementById('genderTotalPenduduk').innerText =
                total.toLocaleString('id-ID') + " orang";

            // ======================
            // BUILD HEADER TABEL
            // ======================
            let thead = `
                <tr>
                    <th width="5%">No</th>
                    <th>Provinsi</th>
                    <th>Jenis Kelamin</th>
            `;

            umurList.forEach(u => {
                thead += `<th class="text-end">${u}</th>`;
            });

            thead += `</tr>`;

            // ======================
            // BUILD BODY TABEL
            // ======================
            let tbody = '';
            let no = 1;

            dataRows.forEach(row => {
                tbody += `
                    <tr>
                        <td>${no++}</td>
                        <td>${row.provinsi}</td>
                        <td>${row.jenis_kelamin === "L" ? "Laki-laki" : "Perempuan"}</td>
                `;

                umurList.forEach(u => {
                    tbody += `
                        <td class="text-end">${Number(row[u] || 0).toLocaleString()}</td>
                    `;
                });

                tbody += `</tr>`;
            });

            document.querySelector("#genderTable thead").innerHTML = thead;
            document.querySelector("#genderTable tbody").innerHTML = tbody;

            // ======================
            // DATATABLES
            // ======================
            genderTable = new DataTable('#genderTable', {
                paging: true,
                pageLength: 10,
                responsive: false,   // MATIKAN! supaya scroll horizontal berfungsi
                scrollX: true,       // HIDUPKAN SCROLL X
                autoWidth: false,
                searching: true,
                ordering: false,
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copyHtml5', title: `Detail Penduduk - ${title}` },
                    { extend: 'excelHtml5', title: `Detail Penduduk - ${title}` },
                    { extend: 'csvHtml5', title: `Detail Penduduk - ${title}` },
                    {
                        extend: 'pdfHtml5',
                        title: `Detail Penduduk - ${title}`,
                        orientation: 'landscape',
                        pageSize: 'A4'
                    },
                    { extend: 'print', title: `Detail Penduduk - ${title}` }
                ]
            });

            if (!genderModalInstance) {
                genderModalInstance = new bootstrap.Modal(document.getElementById('genderModal'));
            }
            genderModalInstance.show();

        });
}


function renderUmurGenderLineChart() {
    const provinsiFilter = document.querySelector('#filterProvince').value || '';
    const jenisKelaminFilter = document.querySelector('#filterGender').value || '';
    const umurFilter = document.querySelector('#filterAge').value || '';

    let queryParams = [];
    if (provinsiFilter) queryParams.push(`provinsi=${encodeURIComponent(provinsiFilter)}`);
    if (jenisKelaminFilter) queryParams.push(`jenis_kelamin=${encodeURIComponent(jenisKelaminFilter)}`);
    if (umurFilter) queryParams.push(`umur=${encodeURIComponent(umurFilter)}`);
    const queryString = queryParams.join('&');

    fetchJson('/dashboard/data/umur-by-gender?' + queryString)
        .then(data => {
            const umurSet = new Set(), male = {}, female = {};

            data.forEach(d => {
                umurSet.add(d.umur);
                if (d.jenis_kelamin === 'L') male[d.umur] = Number(d.total);
                else if (d.jenis_kelamin === 'P') female[d.umur] = Number(d.total);
            });

            const umur = Array.from(umurSet);

            // ==============================
            //  FILTER SERIES BERDASARKAN JENIS KELAMIN
            // ==============================
            let series = [];

            if (jenisKelaminFilter === '' || jenisKelaminFilter === 'L') {
                series.push({
                    name: 'Laki-laki',
                    color: '#2CAFFE',
                    data: umur.map(u => ({ y: male[u] || 0, umur: u, gender: 'L' }))
                });
            }

            if (jenisKelaminFilter === '' || jenisKelaminFilter === 'P') {
                series.push({
                    name: 'Perempuan',
                    color: '#544FC5',
                    data: umur.map(u => ({ y: female[u] || 0, umur: u, gender: 'P' }))
                });
            }

            Highcharts.chart('umurGenderLineChart', {
                chart: { type: 'line' },
                title: { text: '' },

                xAxis: {
                    categories: umur,
                    title: { text: 'Kelompok Umur' }
                },

                yAxis: {
                    title: { text: 'Jumlah Penduduk' },
                    labels: {
                        formatter() {
                            return this.value.toLocaleString('id-ID');
                        }
                    }
                },

                tooltip: {
                    shared: false,
                    valueSuffix: ' orang'
                },

                legend: { enabled: true },

                plotOptions: {
                    series: {
                        cursor: 'pointer',
                        point: {
                            events: {
                                click: function () {
                                    const umurClicked = this.umur;
                                    const genderCode = this.gender;
                                    const genderText = genderCode === 'L' ? 'Laki-laki' : 'Perempuan';

                                    const provinsiFilter = document.querySelector('#filterProvince').value || '';
                                    const jenisKelaminFilter = document.querySelector('#filterGender').value || '';

                                    document.getElementById('genderModalTitle').innerText =
                                        `Detail Penduduk - ${genderText} Umur ${umurClicked}`;

                                    resetGenderTable();

                                    let pivotQuery = `?umur=${encodeURIComponent(umurClicked)}`;
                                    if (provinsiFilter) pivotQuery += `&provinsi=${encodeURIComponent(provinsiFilter)}`;
                                    if (jenisKelaminFilter) pivotQuery += `&jenis_kelamin=${encodeURIComponent(jenisKelaminFilter)}`;

                                    fetch(`/dashboard/data/detail-gender-pivot/${genderCode}${pivotQuery}`)
                                        .then(res => res.json())
                                        .then(res => {
                                            let tbody = '', total = 0;

                                            res.data.forEach((row, i) => {
                                                const jml = Number(row[umurClicked] || 0);
                                                if (jml > 0) {
                                                    total += jml;
                                                    tbody += `
                                                        <tr>
                                                            <td>${i + 1}</td>
                                                            <td>${row.provinsi}</td>
                                                            <td>${genderText}</td>
                                                            <td class="text-end">${jml.toLocaleString('id-ID')}</td>
                                                        </tr>`;
                                                }
                                            });

                                            // TOTAL
                                            document.getElementById('genderTotalPenduduk').innerText =
                                                total.toLocaleString('id-ID') + ' orang';

                                            // HEADER TABEL
                                            document.querySelector('#genderTable thead').innerHTML = `
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th>Provinsi</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th class="text-end">${umurClicked}</th>
                                                </tr>
                                            `;

                                            // ISI TABEL
                                            document.querySelector('#genderTable tbody').innerHTML = tbody;

                                            // Re-init DataTable
                                            genderTable = $('#genderTable').DataTable({
                                                autoWidth: false,
                                                scrollX: true,
                                                paging: true,
                                                searching: true,
                                                ordering: true,
                                                dom: 'Bfrtip',
                                                buttons: [
                                                    { extend: 'copyHtml5', title: `Detail Penduduk - Berdasarkan Umur` },
                                                    { extend: 'excelHtml5', title: `Detail Penduduk - Berdasarkan Umur` },
                                                    { extend: 'csvHtml5', title: `Detail Penduduk - Berdasarkan Umur` },
                                                    {
                                                        extend: 'pdfHtml5',
                                                        title: `Detail Penduduk - Berdasarkan Umur`,
                                                        orientation: 'landscape',
                                                        pageSize: 'A4'
                                                    },
                                                    { extend: 'print', title: `Detail Penduduk - Berdasarkan Umur` }
                                                ]
                                            });

                                            new bootstrap.Modal(document.getElementById('genderModal')).show();
                                        });
                                }
                            }
                        }
                    },

                    line: {
                        marker: { enabled: true, radius: 4 },
                        dataLabels: {
                            enabled: true,
                            allowOverlap: false,
                            formatter() {
                                return this.point.index === this.series.data.length - 1
                                    ? this.y.toLocaleString('id-ID')
                                    : null;
                            },
                            align: 'left',
                            x: 14,
                            style: { fontWeight: 'bold' }
                        }
                    }
                },

                // APPLY FILTER SERIES
                series: series
            });
        });
}





document.addEventListener('show.bs.modal', function () {
    Highcharts.charts.forEach(chart => {
        if (chart && chart.fullscreen?.isOpen) {
            chart.fullscreen.close();
        }
    });
});

function updateTotalPendudukLabel(filters) {
    // filters = { provinsi: null|'ACEH', umur: null|'30-34', gender: null|'L'|'P' }
    
    const provinsiText = filters.provinsi || 'Semua Provinsi';
    const umurText     = filters.umur || 'Semua Umur';
    let genderText     = 'Semua Gender';
    if (filters.gender) genderText = filters.gender === 'L' ? 'Laki-laki' : 'Perempuan';

    document.getElementById('totalPendudukLabel').innerText =
        `${provinsiText} • ${umurText} • ${genderText}`;
}

// Contoh penggunaan saat filter berubah
function onFilterChange() {
    const filters = {
        provinsi: document.querySelector('#filterProvince').value || null,
        umur: document.querySelector('#filterAge').value || null,
        gender: document.querySelector('#filterGender').value || null
    };

    updateTotalPendudukLabel(filters);
}

const PROVINSI_HC_KEY = {
    'ACEH': 'id-ac',
    'SUMATERA UTARA': 'id-su',
    'SUMATERA BARAT': 'id-sb',
    'RIAU': 'id-ri',
    'JAMBI': 'id-ja',
    'SUMATERA SELATAN': 'id-sl',
    'BENGKULU': 'id-be',
    'LAMPUNG': 'id-la',
    'KEP. BANGKA BELITUNG': 'id-bb',
    'KEP. RIAU': 'id-kr',
    'DKI JAKARTA': 'id-jk',
    'JAWA BARAT': 'id-jr',   // ✅ BUKAN id-jb
    'JAWA TENGAH': 'id-jt',
    'DI YOGYAKARTA': 'id-yo',
    'JAWA TIMUR': 'id-ji',
    'BANTEN': 'id-bt',
    'BALI': 'id-ba',
    'NUSA TENGGARA BARAT': 'id-nb',
    'NUSA TENGGARA TIMUR': 'id-nt',
    'KALIMANTAN BARAT': 'id-kb',
    'KALIMANTAN TENGAH': 'id-kt',
    'KALIMANTAN SELATAN': 'id-ks',
    'KALIMANTAN TIMUR': 'id-ki',
    'KALIMANTAN UTARA': 'id-ku',
    'SULAWESI UTARA': 'id-sw',
    'SULAWESI TENGAH': 'id-st',
    'SULAWESI SELATAN': 'id-se',
    'SULAWESI TENGGARA': 'id-sg',
    'GORONTALO': 'id-go',
    'SULAWESI BARAT': 'id-sr',
    'MALUKU': 'id-ma',
    'MALUKU UTARA': 'id-mu', // ✅ BUKAN id-ib
    'PAPUA': 'id-pa',
    'PAPUA BARAT': 'id-pb'
};
function renderProvinsiMap() {

    const selectedProvinsi = document.querySelector('#filterProvince').value;
    const jenisKelaminFilter = document.querySelector('#filterGender').value || '';
    const umurFilter = document.querySelector('#filterAge').value || '';


    Promise.all([
        fetchJson(
            '/dashboard/data/map-provinsi?' +
            new URLSearchParams({
                jenis_kelamin: filterGender.value,
                umur: filterAge.value,
                provinsi: selectedProvinsi
            })
        ),
        fetch('https://code.highcharts.com/mapdata/countries/id/id-all.geo.json')
            .then(r => r.json())
    ])
    .then(([data, map]) => {

        /* =====================================
           ✅ 1. Tentukan provinsi "terbanyak"
        ===================================== */
        let topProvince;

        if (selectedProvinsi) {
            // ✅ jika filter provinsi aktif → itu langsung jadi top
            topProvince = data.find(d => d.provinsi === selectedProvinsi);
        } else {
            // ✅ global terbanyak
            topProvince = data.reduce((max, cur) =>
                Number(cur.total) > Number(max.total) ? cur : max
            , data[0]);
        }

        const topProvName  = topProvince?.provinsi;
        const topProvTotal = Number(topProvince?.total || 0);

        /* =====================================
           ✅ 2. Build series data
        ===================================== */
        const seriesData = data.map(d => {
            const hcKey = PROVINSI_HC_KEY[d.provinsi];
            if (!hcKey) return null;

            const realValue = Number(d.total);

            let value = realValue;

            // ✅ visual redup jika bukan top & bukan selected
            if (
                selectedProvinsi &&
                d.provinsi !== selectedProvinsi
            ) {
                value = 0;
            }

            return {
                'hc-key': hcKey,
                name: d.provinsi,
                value: value,
                realValue: realValue,
                isTop: d.provinsi === topProvName
            };
        }).filter(Boolean);

        const maxValue = Math.max(...seriesData.map(d => d.value), 1);

        /* =====================================
           ✅ 3. Render MAP
        ===================================== */
        Highcharts.mapChart('provinsiMap', {
            chart: { map },

            title: {
                text: 'Sebaran Penduduk per Provinsi'
            },

            subtitle: {
                text: `
                    Provinsi Terbanyak:
                    <b>${topProvName}</b>
                    (${topProvTotal.toLocaleString('id-ID')} jiwa)
                `,
                useHTML: true
            },

            mapNavigation: {
                enabled: true
            },

            colorAxis: {
                min: 0,
                max: maxValue,
                minColor: '#E3F2FD',
                maxColor: '#0D47A1'
            },

            tooltip: {
                useHTML: true,
                pointFormatter() {
                    return `
                        <b>${this.name}</b><br>
                        Total Penduduk:
                        <b>${this.realValue.toLocaleString('id-ID')}</b> jiwa
                    `;
                }
            },

            series: [{
                type: 'map',
                data: seriesData,
                joinBy: 'hc-key',
                name: 'Penduduk',
                cursor: 'pointer',
                nullColor: '#f0f0f0',

                states: {
                    hover: { color: '#FF7043' }
                },

                point: {
                    events: {
                        click: function () {
                            // 🔥 INI KUNCINYA
                            openProvinsiMapDetail(this.name, jenisKelaminFilter, umurFilter);
                        }
                    }
                },

                dataLabels: {
                    enabled: true,
                    allowOverlap: true,
                    formatter() {
                        if (this.point.isTop) {
                            return `
                                <b>${this.point.realValue
                                    .toLocaleString('id-ID')}</b>
                            `;
                        }
                        return null;
                    },
                    style: {
                        fontWeight: 'bold',
                        fontSize: '11px',
                        color: '#000',
                        textOutline: '2px contrast'
                    }
                }
            }]

        });

    });
}

// let genderTable = null;
function openProvinsiMapDetail(provinsi, jenisKelaminFilter, umurFilter) {
    document.getElementById('genderModalTitle').innerText =
        `Detail Penduduk - Provinsi ${provinsi}`;

    if ($.fn.DataTable.isDataTable('#genderTable')) {
        $('#genderTable').DataTable().destroy();
    }

    const params = new URLSearchParams({
        provinsi: provinsi,
        jenis_kelamin: jenisKelaminFilter || '',
        umur: umurFilter || ''
    }).toString();

    fetch(`/dashboard/data/detail-provinsi-pivot/${encodeURIComponent(provinsi)}?${params}`)
        .then(res => res.json())
        .then(res => {

            // ----------------------------
            // 1️⃣ TENTUKAN UMUR YANG DITAMPILKAN
            // ----------------------------
            let umurList = res.umur;

            if (umurFilter && umurFilter !== '') {
                // hanya tampil 1 kolom umur
                umurList = [umurFilter];
            }

            // ----------------------------
            // 2️⃣ FILTER DATA BERDASARKAN JENIS KELAMIN
            // ----------------------------
            let dataFiltered = res.data;

            if (jenisKelaminFilter && jenisKelaminFilter !== '') {
                dataFiltered = res.data.filter(d => d.jenis_kelamin === jenisKelaminFilter);
            }

            // ----------------------------
            // 3️⃣ HITUNG GRAND TOTAL
            // ----------------------------
            let grandTotal = 0;
            dataFiltered.forEach(row => {
                umurList.forEach(u => {
                    grandTotal += Number(row[u] || 0);
                });
            });

            document.getElementById('genderTotalPenduduk').innerText =
                grandTotal.toLocaleString('id-ID') + ' orang';

            // ----------------------------
            // 4️⃣ HEADER TABEL DINAMIS
            // ----------------------------
            let thead = `<tr>
                <th>No</th>
                <th>Jenis Kelamin</th>`;

            umurList.forEach(u => {
                thead += `<th class="text-end">${u}</th>`;
            });

            thead += `<th class="text-end">Total</th></tr>`;

            // ----------------------------
            // 5️⃣ BODY TABEL DINAMIS
            // ----------------------------
            let tbody = '';

            dataFiltered.forEach((row, i) => {
                let total = 0;
                tbody += `<tr>
                    <td>${i + 1}</td>
                    <td>${row.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'}</td>`;

                umurList.forEach(u => {
                    const val = Number(row[u] || 0);
                    total += val;
                    tbody += `<td class="text-end">${val.toLocaleString('id-ID')}</td>`;
                });

                tbody += `<td class="text-end fw-bold">${total.toLocaleString('id-ID')}</td>
                </tr>`;
            });

            // Tempel HTML
            document.querySelector('#genderTable thead').innerHTML = thead;
            document.querySelector('#genderTable tbody').innerHTML = tbody;

            // ----------------------------
            // 6️⃣ RE-INIT DATATABLE
            // ----------------------------
            genderTable = $('#genderTable').DataTable({
                destroy: true,
                scrollX: true,
                scrollCollapse: true,
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copyHtml5', title: `Detail Penduduk - Provinsi ${provinsi}` },
                    { extend: 'excelHtml5', title: `Detail Penduduk - Provinsi ${provinsi}` },
                    { extend: 'csvHtml5', title: `Detail Penduduk - Provinsi ${provinsi}` },
                    {
                        extend: 'pdfHtml5',
                        title: `Detail Penduduk - Provinsi ${provinsi}`,
                        orientation: 'landscape',
                        pageSize: 'A4'
                    },
                    { extend: 'print', title: `Detail Penduduk - Provinsi ${provinsi}` }
                ]
            });

            showGenderModal();
        });
}


function toHcKey(prov) {
    return prov
        .toLowerCase()
        .replace('kep. ', '')
        .replace(/\./g, '')
        .replace(/ /g, '-');
}

function updateFilterBadges() {
    const gender = document.getElementById("filterGender").value;
    const umur = document.getElementById("filterAge").value;
    const prov = document.getElementById("filterProvince").value;

    let active = false;

    // Reset badge
    document.getElementById("badgeGender").style.display = "none";
    document.getElementById("badgeUmur").style.display = "none";
    document.getElementById("badgeProvinsi").style.display = "none";

    // Gender
    if (gender) {
        document.getElementById("badgeGender").innerText =
            gender === "L" ? "Laki-laki" : "Perempuan";
        document.getElementById("badgeGender").style.display = "inline-block";
        active = true;
    }

    // Umur
    if (umur) {
        document.getElementById("badgeUmur").innerText = `Umur ${umur}`;
        document.getElementById("badgeUmur").style.display = "inline-block";
        active = true;
    }

    // Provinsi
    if (prov) {
        document.getElementById("badgeProvinsi").innerText = prov;
        document.getElementById("badgeProvinsi").style.display = "inline-block";
        active = true;
    }

    // Show / hide container
    document.getElementById("activeFilterInfo").style.display = active ? "block" : "none";
}

// Event listener
["filterGender", "filterAge", "filterProvince"].forEach(id => {
    document.getElementById(id).addEventListener("change", updateFilterBadges);
});

document.getElementById("btnRefresh").addEventListener("click", () => {
    document.getElementById("filterGender").value = "";
    document.getElementById("filterAge").value = "";
    document.getElementById("filterProvince").value = "";

    updateFilterBadges();
});

// GLOBAL MODAL INSTANCE
genderModalInstance = new bootstrap.Modal(document.getElementById('genderModal'));

</script>
@endpush

