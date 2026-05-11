<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
  public function index(Request $request)
  {
    $kelasList = Kelas::orderBy('nama_kelas')->get();
    $siswaList = Siswa::with('kelas')->orderBy('nama')->get();

    $query = Transaksi::with(['siswa.kelas', 'user'])->latest();

    // Filter per siswa
    if ($request->filled('siswa_id')) {
      $query->where('siswa_id', $request->siswa_id);
    }

    // Filter per kelas
    if ($request->filled('kelas_id')) {
      $query->whereHas('siswa', fn($q) => $q->where('kelas_id', $request->kelas_id));
    }

    // Filter per bulan
    if ($request->filled('bulan')) {
      $query->whereMonth('created_at', $request->bulan);
    }

    // Filter per tahun
    if ($request->filled('tahun')) {
      $query->whereYear('created_at', $request->tahun);
    }

    $transaksi = $query->get();

    // Ringkasan
    $totalTabung = $transaksi->where('jenis', 'tabung')->sum('jumlah');
    $totalTarik = $transaksi->where('jenis', 'tarik')->sum('jumlah');
    $totalNet = $totalTabung - $totalTarik;

    // Untuk daftar tahun di filter (ambil dari data transaksi)
    $tahunList = Transaksi::selectRaw('YEAR(created_at) as tahun')
      ->distinct()
      ->orderBy('tahun', 'desc')
      ->pluck('tahun');

    return view('laporan.index', compact(
      'transaksi',
      'kelasList',
      'siswaList',
      'tahunList',
      'totalTabung',
      'totalTarik',
      'totalNet'
    ));
  }

  public function export(Request $request)
  {
    $query = Transaksi::with(['siswa.kelas', 'user'])->latest();

    if ($request->filled('siswa_id')) {
      $query->where('siswa_id', $request->siswa_id);
    }
    if ($request->filled('kelas_id')) {
      $query->whereHas('siswa', fn($q) => $q->where('kelas_id', $request->kelas_id));
    }
    if ($request->filled('bulan')) {
      $query->whereMonth('created_at', $request->bulan);
    }
    if ($request->filled('tahun')) {
      $query->whereYear('created_at', $request->tahun);
    }

    $transaksi = $query->get();
    $totalTabung = $transaksi->where('jenis', 'tabung')->sum('jumlah');
    $totalTarik = $transaksi->where('jenis', 'tarik')->sum('jumlah');
    $totalNet = $totalTabung - $totalTarik;

    // Label filter untuk header PDF
    $filterLabel = $this->buildFilterLabel($request);

    // Ambil data user bendahara dan ketua untuk tanda tangan
    $bendahara = \App\Models\User::where('role', 'bendahara')->first();
    $ketua = \App\Models\User::where('role', 'ketua')->first();

    $pdf = Pdf::loadView('laporan.pdf', compact(
      'transaksi',
      'totalTabung',
      'totalTarik',
      'totalNet',
      'filterLabel',
      'bendahara',
      'ketua'
    ))->setPaper('a4', 'landscape');

    $filename = 'laporan-tabungan-' . now()->format('Ymd-His') . '.pdf';

    return $pdf->download($filename);
  }

  private function buildFilterLabel(Request $request): string
  {
    $parts = [];

    if ($request->filled('siswa_id')) {
      $siswa = Siswa::find($request->siswa_id);
      if ($siswa)
        $parts[] = 'Siswa: ' . $siswa->nama;
    }
    if ($request->filled('kelas_id')) {
      $kelas = Kelas::find($request->kelas_id);
      if ($kelas)
        $parts[] = 'Kelas: ' . $kelas->nama_kelas;
    }
    if ($request->filled('bulan')) {
      $bulanNama = [
        '',
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
      ];
      $parts[] = 'Bulan: ' . ($bulanNama[(int) $request->bulan] ?? $request->bulan);
    }
    if ($request->filled('tahun')) {
      $parts[] = 'Tahun: ' . $request->tahun;
    }

    return empty($parts) ? 'Semua Data' : implode(' | ', $parts);
  }
}