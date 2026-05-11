<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Transaksi;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
  public function index()
  {
    $totalSiswa = Siswa::count();
    $totalTabungan = Siswa::sum('saldo');
    $transaksiHariIni = Transaksi::whereDate('created_at', today())->count();

    // Data grafik: transaksi 7 hari terakhir
    $grafikTransaksi = Transaksi::select(
      DB::raw('DATE(created_at) as tanggal'),
      DB::raw('SUM(CASE WHEN jenis = "tabung" THEN jumlah ELSE 0 END) as total_tabung'),
      DB::raw('SUM(CASE WHEN jenis = "tarik" THEN jumlah ELSE 0 END) as total_tarik')
    )
      ->where('created_at', '>=', now()->subDays(6))
      ->groupBy('tanggal')
      ->orderBy('tanggal')
      ->get();

    // Data grafik: total tabungan per kelas
    $grafikKelas = Kelas::withSum('siswa', 'saldo')
      ->get()
      ->map(fn($k) => [
        'nama' => $k->nama_kelas,
        'total' => $k->siswa_sum_saldo ?? 0,
      ]);

    return view('dashboard', compact(
      'totalSiswa',
      'totalTabungan',
      'transaksiHariIni',
      'grafikTransaksi',
      'grafikKelas'
    ));
  }
}