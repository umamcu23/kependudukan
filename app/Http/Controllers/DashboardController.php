<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    protected function baseQuery(Request $request)
    {
        $q = DB::table('penduduk')
            ->where('provinsi','!=','INDONESIA');

        if ($request->filled('jenis_kelamin')) {
            $q->where('jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->filled('umur')) {
            $q->where('umur', $request->umur);
        }

        if ($request->filled('provinsi')) {
            $q->where('provinsi', $request->provinsi);
        }

        return $q;
    }



    public function index()
    {
        $provinsi = DB::table('penduduk')
        ->where('provinsi','!=','INDONESIA')
        ->select('provinsi')
        ->distinct()
        ->orderBy('provinsi')
        ->pluck('provinsi');
        
        return view('dashboard', compact('provinsi'));
    }

    // Pie: Jenis Kelamin
    public function summary()
    {
        return $this->baseQuery()
            ->select('jenis_kelamin', DB::raw('SUM(jumlah) as total'))
            ->groupBy('jenis_kelamin')
            ->get();
    }

    // Column: Provinsi
    public function byProvinsi(Request $request)
    {
        return response()->json(
            $this->baseQuery($request)
                ->select('provinsi', DB::raw('SUM(jumlah) as total'))
                ->groupBy('provinsi')
                ->orderByDesc('total')
                ->get()
        );
    }


   public function byUmur(Request $request)
    {
        return response()->json(
            $this->baseQuery($request)
                ->select('umur','jenis_kelamin', DB::raw('SUM(jumlah) as total'))
                ->groupBy('umur','jenis_kelamin')
                ->orderByRaw("
                    CASE
                        WHEN umur LIKE '%+%' 
                            THEN CAST(REPLACE(umur,'+','') AS UNSIGNED)
                        ELSE CAST(SUBSTRING_INDEX(umur,'-',1) AS UNSIGNED)
                    END
                ")
                ->get()
        );
    }


    // Trend Line
    public function trend(Request $request)
    {
        return response()->json(
            $this->baseQuery($request)
                ->select('tahun', DB::raw('SUM(jumlah) as total'))
                ->groupBy('tahun')
                ->orderBy('tahun')
                ->get()
        );
    }


    public function detailByGender($gender)
    {
        return DB::table('penduduk')
            ->select(
                'provinsi',
                'umur',
                'jenis_kelamin',
                DB::raw('SUM(jumlah) as jumlah')
            )
            ->where('provinsi', '!=', 'INDONESIA')
            ->where('jenis_kelamin', $gender)
            ->groupBy('provinsi', 'umur', 'jenis_kelamin')
            ->orderBy('provinsi')
            ->orderByRaw("
                CASE
                    WHEN umur LIKE '%+%' THEN CAST(REPLACE(umur,'+','') AS UNSIGNED)
                    ELSE CAST(SUBSTRING_INDEX(umur,'-',1) AS UNSIGNED)
                END
            ")
            ->get();
    }


    public function detailByGenderTable(Request $request, $gender)
    {
        $query = DB::table('penduduk')
            ->select(
                'provinsi',
                'umur',
                'jenis_kelamin',
                DB::raw('SUM(jumlah) as jumlah')
            )
            ->where('provinsi', '!=', 'INDONESIA')
            ->where('jenis_kelamin', $gender)
            ->groupBy('provinsi', 'umur', 'jenis_kelamin');

        return datatables()->of($query)
            ->editColumn('jenis_kelamin', function ($row) {
                return $row->jenis_kelamin === 'L'
                    ? 'Laki-laki'
                    : 'Perempuan';
            })
            ->editColumn('jumlah', function ($row) {
                return number_format($row->jumlah);
            })
            ->make(true);
    }

    public function genderSummary(Request $request)
    {
        return $this->baseQuery($request)
            ->select('jenis_kelamin', DB::raw('SUM(jumlah) as total'))
            ->groupBy('jenis_kelamin')
            ->get();
    }

    public function kpi(Request $request)
    {
        $base = $this->baseQuery($request);

        // TOTAL LK & PR
        $byGender = (clone $base)
            ->select('jenis_kelamin', DB::raw('SUM(jumlah) as total'))
            ->groupBy('jenis_kelamin')
            ->get()
            ->keyBy('jenis_kelamin');

        // TOTAL SEMUA
        $totalPenduduk = (clone $base)
            ->sum('jumlah');

        // UMUR TERBANYAK (L + P)
        $umurTerbanyak = (clone $base)
            ->select('umur', DB::raw('SUM(jumlah) as total'))
            ->groupBy('umur')
            ->orderByDesc('total')
            ->first();

        return response()->json([
            'laki_laki' => $byGender['L']->total ?? 0,
            'perempuan' => $byGender['P']->total ?? 0,
            'total' => $totalPenduduk,
            'umur_terbanyak' => $umurTerbanyak
        ]);
    }

    public function detailByProvinsiTable(Request $request, $provinsi)
    {
        $query = DB::table('penduduk')
            ->select(
                'provinsi',
                'umur',
                'jenis_kelamin',
                DB::raw('SUM(jumlah) as jumlah')
            )
            ->where('provinsi', $provinsi)
            ->groupBy('provinsi', 'umur', 'jenis_kelamin')
            ->orderByRaw("
                CASE
                    WHEN umur LIKE '%+%' THEN CAST(REPLACE(umur,'+','') AS UNSIGNED)
                    ELSE CAST(SUBSTRING_INDEX(umur,'-',1) AS UNSIGNED)
                END
            ");

        return datatables()->of($query)
            ->editColumn('jenis_kelamin', function ($row) {
                return $row->jenis_kelamin === 'L'
                    ? 'Laki-laki'
                    : 'Perempuan';
            })
            ->editColumn('jumlah', function ($row) {
                return number_format($row->jumlah);
            })
            ->make(true);
    }


    private function umurList()
    {
        return [
            '00-04','05-09','10-14','15-19','20-24',
            '25-29','30-34','35-39','40-44','45-49',
            '50-54','55-59','60-64','65-69','70-74',
            '75-79','80-84','85-89','90-94','95+'
        ];
    }


  public function detailProvinsiPivot(Request $request, $provinsi)
{
    $umurList = $this->umurList();

    $query = DB::table('penduduk')
        ->select(
            'provinsi',
            'jenis_kelamin',
            'umur',
            DB::raw('SUM(jumlah) as total')
        )
        ->where('provinsi', $provinsi);

    // ✅ Filter aktif
    if ($request->has('jenis_kelamin') && $request->jenis_kelamin) {
        $query->where('jenis_kelamin', $request->jenis_kelamin);
    }

    if ($request->has('umur') && $request->umur) {
        $query->where('umur', $request->umur);
    }

    $rows = $query
        ->groupBy('provinsi', 'jenis_kelamin', 'umur')
        ->get();

    // Pivot manual
    $result = [];
    foreach ($rows as $row) {
        $key = $row->provinsi.'-'.$row->jenis_kelamin;

        if (!isset($result[$key])) {
            $result[$key] = [
                'provinsi' => $row->provinsi,
                'jenis_kelamin' => $row->jenis_kelamin,
            ];

            foreach ($umurList as $u) {
                $result[$key][$u] = 0;
            }
        }

        $result[$key][$row->umur] = $row->total;
    }

    return response()->json([
        'umur' => $umurList,
        'data' => array_values($result)
    ]);
}


   public function detailGenderPivot(Request $request, $gender)
    {
        $query = DB::table('penduduk')
            ->select('provinsi','jenis_kelamin','umur', DB::raw('SUM(jumlah) as total'))
            ->where('jenis_kelamin', $gender)
            ->where('provinsi','!=','INDONESIA');

        // Terapkan semua filter aktif
        if($request->filled('provinsi')) $query->where('provinsi', $request->provinsi);
        if($request->filled('umur')) $query->where('umur', $request->umur);

        $rows = $query->groupBy('provinsi','jenis_kelamin','umur')->get();

        // Pivot hanya untuk umur yang diklik / aktif
        $umurList = $request->filled('umur') ? collect([$request->umur]) : $rows->pluck('umur')->unique();

        $pivot = [];
        foreach($rows as $r){
            $key = $r->provinsi.'_'.$r->jenis_kelamin;
            if(!isset($pivot[$key])){
                $pivot[$key] = [
                    'provinsi'=>$r->provinsi,
                    'jenis_kelamin'=>$r->jenis_kelamin
                ];
                foreach($umurList as $u) $pivot[$key][$u] = 0;
            }
            $pivot[$key][$r->umur] = $r->total;
        }

        return response()->json([
            'umur'=>$umurList->values(),
            'data'=>array_values($pivot)
        ]);
    }





    // Trend Line by Umur
    public function umurByGender(Request $request)
    {
        return response()->json(
            $this->baseQuery($request)
                ->select(
                    'umur',
                    'jenis_kelamin',
                    DB::raw('SUM(jumlah) as total')
                )
                ->groupBy('umur', 'jenis_kelamin')
                ->orderByRaw("
                    CASE
                        WHEN umur LIKE '%+%'
                            THEN CAST(REPLACE(umur,'+','') AS UNSIGNED)
                        ELSE CAST(SUBSTRING_INDEX(umur,'-',1) AS UNSIGNED)
                    END
                ")
                ->get()
        );
    }


    public function mapProvinsi(Request $request)
    {
        $query = DB::table('penduduk');

        if ($request->umur) {
            $query->where('umur', $request->umur);
        }

        if ($request->jenis_kelamin) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->tahun) {
            $query->where('tahun', $request->tahun);
        }

        $data = $query
            ->select('provinsi', DB::raw('SUM(jumlah) AS total'))
            ->where('provinsi','!=','INDONESIA')
            ->groupBy('provinsi')
            ->orderBy('provinsi')
            ->get();

        return response()->json($data);
    }

}