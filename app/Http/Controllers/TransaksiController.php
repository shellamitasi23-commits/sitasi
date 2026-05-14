<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
  public function index(Request $request)
  {
    $query = Transaksi::with(['siswa.kelas', 'user'])
      ->latest();

    // Filter opsional
    if ($request->filled('siswa_id')) {
      $query->where('siswa_id', $request->siswa_id);
    }
    if ($request->filled('jenis')) {
      $query->where('jenis', $request->jenis);
    }
    if ($request->filled('bulan')) {
      $query->whereMonth('created_at', $request->bulan);
    }
    if ($request->filled('tahun')) {
      $query->whereYear('created_at', $request->tahun);
    }

    $transaksi = $query->paginate(15)->withQueryString();
    $siswaList = Siswa::with('kelas')->orderBy('nama')->get();

    return view('transaksi.index', compact('transaksi', 'siswaList'));
  }

  public function trashed()
  {
    $transaksi = Transaksi::onlyTrashed()
      ->with(['siswa.kelas', 'user'])
      ->latest('deleted_at')
      ->paginate(15);

    return view('transaksi.trashed', compact('transaksi'));
  }

  public function create()
  {
    $siswaList = Siswa::with('kelas')->orderBy('nama')->get();
    return view('transaksi.create', compact('siswaList'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'siswa_id' => 'required|exists:siswa,id',
      'nama_petugas' => 'required|string|max:100',
      'jenis' => 'required|in:tabung,tarik',
      'jumlah' => 'required|numeric|min:500',
      'keterangan' => 'nullable|string|max:255',
    ], 
    [
      'jumlah.min' => 'Jumlah transaksi minimal Rp 500.',
    ]);

    $siswa = Siswa::lockForUpdate()->findOrFail($request->siswa_id);

    // Validasi: saldo tidak boleh minus saat tarik
    if ($request->jenis === 'tarik' && $request->jumlah > $siswa->saldo) {
      return back()
        ->withInput()
        ->with('error', 'Saldo tidak mencukupi. Saldo saat ini: Rp ' . number_format($siswa->saldo, 0, ',', '.'));
    }

    DB::transaction(function () use ($request, $siswa) {
      $saldo_sebelum = $siswa->saldo;

      $saldo_sesudah = $request->jenis === 'tabung'
        ? $saldo_sebelum + $request->jumlah
        : $saldo_sebelum - $request->jumlah;

      Transaksi::create([
        'siswa_id' => $siswa->id,
        'user_id' => Auth::id(),
        'nama_petugas' => $request->nama_petugas,
        'jenis' => $request->jenis,
        'jumlah' => $request->jumlah,
        'saldo_sebelum' => $saldo_sebelum,
        'saldo_sesudah' => $saldo_sesudah,
        'keterangan' => $request->keterangan,
      ]);

      // Update saldo di tabel siswa
      $siswa->update(['saldo' => $saldo_sesudah]);
    });

    return redirect()->route('transaksi.index')
      ->with('success', 'Transaksi berhasil dicatat.');
  }

  public function show(Transaksi $transaksi)
  {
    $transaksi->load(['siswa.kelas', 'user']);
    return view('transaksi.show', compact('transaksi'));
  }

  public function cetak(Transaksi $transaksi)
  {
    $transaksi->load(['siswa.kelas', 'user']);
    return view('transaksi.cetak', compact('transaksi'));
  }

  public function edit(Transaksi $transaksi)
  {
    // Transaksi keuangan tidak boleh diedit — hanya bisa dihapus
    // Ini menjaga integritas audit trail
    return redirect()->route('transaksi.index')
      ->with('error', 'Transaksi tidak dapat diedit. Hapus dan buat transaksi baru jika ada kesalahan.');
  }

  public function update(Request $request, Transaksi $transaksi)
  {
    return redirect()->route('transaksi.index')
      ->with('error', 'Transaksi tidak dapat diedit.');
  }

  public function destroy(Request $request, Transaksi $transaksi)
  {
    $request->validate([
      'alasan_hapus' => 'required|string|max:255',
    ]);

    $siswa = Siswa::lockForUpdate()->findOrFail($transaksi->siswa_id);

    DB::transaction(function () use ($request, $transaksi, $siswa) {
      // Balik efek transaksi ke saldo siswa
      if ($transaksi->jenis === 'tabung') {
        $siswa->update(['saldo' => $siswa->saldo - $transaksi->jumlah]);
      } else {
        $siswa->update(['saldo' => $siswa->saldo + $transaksi->jumlah]);
      }

      // Simpan alasan dan siapa yang menghapus
      $transaksi->update([
        'alasan_hapus' => $request->alasan_hapus,
        'user_id_hapus' => Auth::id(),
      ]);

      $transaksi->delete(); // Soft delete
    });

    return redirect()->route('transaksi.index')
      ->with('success', 'Transaksi berhasil dihapus (soft-delete) dan saldo telah disesuaikan.');
  }
}