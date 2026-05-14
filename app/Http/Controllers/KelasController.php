<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
  public function index()
  {
    $kelas = Kelas::withCount('siswa')->latest()->get();
    return view('kelas.index', compact('kelas'));
  }

  public function create()
  {
    return view('kelas.create');
  }

  public function store(Request $request)
  {
    $request->validate([
      'nama_kelas' => 'required|string|max:50',
      'tahun_ajaran' => 'required|string|max:20',
    ], [
      'nama_kelas.required' => 'Nama kelas wajib diisi.',
      'tahun_ajaran.required' => 'Tahun ajaran wajib diisi.',
    ]);

    Kelas::create($request->only('nama_kelas', 'tahun_ajaran'));

    return redirect()->route('kelas.index')
      ->with('success', 'Kelas berhasil ditambahkan.');
  }

  public function edit(Kelas $kelas)
  {
    return view('kelas.edit', compact('kelas'));
  }

  public function update(Request $request, Kelas $kelas)
  {
    $request->validate([
      'nama_kelas' => 'required|string|max:50',
      'tahun_ajaran' => 'required|string|max:20',
    ], [
      'nama_kelas.required' => 'Nama kelas wajib diisi.',
      'tahun_ajaran.required' => 'Tahun ajaran wajib diisi.',
    ]);

    $kelas->update($request->only('nama_kelas', 'tahun_ajaran'));

    return redirect()->route('kelas.index')
      ->with('success', 'Kelas berhasil diperbarui.');
  }

  public function destroy(Kelas $kelas)
  {
    if ($kelas->siswa()->count() > 0) {
      return redirect()->route('kelas.index')
        ->with('error', 'Kelas tidak bisa dihapus karena masih memiliki siswa.');
    }

    $kelas->delete();

    return redirect()->route('kelas.index')
      ->with('success', 'Kelas berhasil dihapus.');
  }
}