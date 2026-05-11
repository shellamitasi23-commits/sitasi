<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
  public function index()
  {
    $siswa = Siswa::with('kelas')->latest()->get();
    return view('siswa.index', compact('siswa'));
  }

  public function create()
  {
    $kelas = Kelas::all();
    return view('siswa.create', compact('kelas'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'kelas_id' => 'required|exists:kelas,id',
      'nama' => 'required|string|max:100',
    ], [
      'kelas_id.required' => 'Kelas wajib dipilih.',
      'kelas_id.exists' => 'Kelas tidak valid.',
      'nama.required' => 'Nama siswa wajib diisi.',
    ]);

    Siswa::create([
      'kelas_id' => $request->kelas_id,
      'nama' => $request->nama,
      'saldo' => 0,
    ]);

    return redirect()->route('siswa.index')
      ->with('success', 'Siswa berhasil ditambahkan.');
  }

  public function show(Siswa $siswa)
  {
    $siswa->load('kelas', 'transaksi');
    return view('siswa.show', compact('siswa'));
  }

  public function edit(Siswa $siswa)
  {
    $kelas = Kelas::all();
    return view('siswa.edit', compact('siswa', 'kelas'));
  }

  public function update(Request $request, Siswa $siswa)
  {
    $request->validate([
      'kelas_id' => 'required|exists:kelas,id',
      'nama' => 'required|string|max:100',
    ], [
      'kelas_id.required' => 'Kelas wajib dipilih.',
      'nama.required' => 'Nama siswa wajib diisi.',
    ]);

    $siswa->update($request->only('kelas_id', 'nama'));

    return redirect()->route('siswa.index')
      ->with('success', 'Data siswa berhasil diperbarui.');
  }

  public function destroy(Siswa $siswa)
  {
    if ($siswa->saldo > 0) {
      return redirect()->route('siswa.index')
        ->with('error', 'Siswa tidak bisa dihapus karena masih memiliki saldo Rp ' . number_format($siswa->saldo, 0, ',', '.'));
    }

    $siswa->delete();

    return redirect()->route('siswa.index')
      ->with('success', 'Siswa berhasil dihapus.');
  }
}