@extends('layouts.app')
@section('title', 'Edit Siswa')

@section('content')

<div class="flex items-center gap-3 mb-5">
    <a href="{{ route('siswa.index') }}" 
       class="flex items-center justify-center w-[34px] h-[34px] bg-white border border-slate-200 rounded-lg text-slate-500 hover:bg-slate-50 transition-colors">
        <i class="ti ti-arrow-left text-base" aria-hidden="true"></i>
    </a>
    <div>
        <div class="text-xl font-bold text-slate-900">Edit Siswa</div>
        <div class="text-sm text-slate-500 mt-0.5">Perbarui data {{ $siswa->nama }}</div>
    </div>
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
    <div class="bg-slate-50/50 px-6 py-4 border-b border-slate-100">
        <div class="text-base font-bold text-slate-900">Form Edit Siswa</div>
        <div class="text-sm text-slate-500 mt-1">Perbarui data siswa yang sudah ada</div>
    </div>
    <div class="p-6">

        {{-- Info saldo (tidak bisa diubah manual) --}}
        <div class="bg-slate-50 border border-blue-100 rounded-xl p-4 flex items-center gap-3 mb-5">
            <i class="ti ti-piggy-bank text-2xl text-emerald-600" aria-hidden="true"></i>
            <div>
                <div class="text-xs text-slate-500">Saldo saat ini</div>
                <div class="text-base font-semibold text-emerald-600">Rp {{ number_format($siswa->saldo, 0, ',', '.') }}</div>
            </div>
            <div class="ml-auto text-xs text-slate-400">Saldo hanya bisa diubah melalui transaksi</div>
        </div>

        @if($errors->any())
            <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 px-4 py-3 rounded-lg text-sm mb-5">✕ {{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('siswa.update', $siswa) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4 mb-5">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap Siswa</label>
                    <input type="text" name="nama" value="{{ old('nama', $siswa->nama) }}"
                           class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm text-slate-900 bg-white outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition-colors">
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Kelas</label>
                <select name="kelas_id" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm text-slate-900 bg-white outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition-colors">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ old('kelas_id', $siswa->kelas_id) == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }} — {{ $k->tahun_ajaran }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-3 pt-4 border-t border-slate-100 mt-2">
                <button type="submit" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition-colors">
                    <i class="ti ti-check" aria-hidden="true"></i> Perbarui Siswa
                </button>
                <a href="{{ route('siswa.index') }}" class="inline-flex items-center justify-center bg-slate-50 hover:bg-slate-100 text-slate-700 px-5 py-2.5 rounded-lg text-sm font-semibold border border-slate-200 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection