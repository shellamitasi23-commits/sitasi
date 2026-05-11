@extends('layouts.app')
@section('title', 'Edit Kelas')

@section('content')

<div class="flex items-center gap-3 mb-5">
    <a href="{{ route('kelas.index') }}" 
       class="flex items-center justify-center w-[34px] h-[34px] bg-white border border-slate-200 rounded-lg text-slate-500 hover:bg-slate-50 transition-colors">
        <i class="ti ti-arrow-left text-base" aria-hidden="true"></i>
    </a>
    <div>
        <div class="text-xl font-bold text-slate-900">Edit Kelas {{ $kelas->nama_kelas }}</div>
        <div class="text-sm text-slate-500 mt-0.5">Perbarui data kelas</div>
    </div>
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
    <div class="bg-slate-50/50 px-6 py-4 border-b border-slate-100">
        <div class="text-base font-bold text-slate-900">Form Edit Kelas</div>
        <div class="text-sm text-slate-500 mt-1">Perbarui data kelas yang sudah ada</div>
    </div>
    <div class="p-6">

        @if($errors->any())
            <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 px-4 py-3 rounded-lg text-sm mb-5">✕ {{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('kelas.update', $kelas) }}">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Kelas</label>
                <input type="text" name="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}"
                       class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm text-slate-900 bg-white outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition-colors">
                <div class="text-xs text-slate-500 mt-1.5">Gunakan format huruf + angka, misal A1 atau B2</div>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Tahun Ajaran</label>
                <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', $kelas->tahun_ajaran) }}"
                       class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-sm text-slate-900 bg-white outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition-colors">
                <div class="text-xs text-slate-500 mt-1.5">Gunakan format tahun/tahun, misal 2024/2025</div>
            </div>

            <div class="flex gap-3 pt-4 border-t border-slate-100 mt-2">
                <button type="submit" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition-colors">
                    <i class="ti ti-check" aria-hidden="true"></i> Perbarui Kelas
                </button>
                <a href="{{ route('kelas.index') }}" class="inline-flex items-center justify-center bg-slate-50 hover:bg-slate-100 text-slate-700 px-5 py-2.5 rounded-lg text-sm font-semibold border border-slate-200 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection