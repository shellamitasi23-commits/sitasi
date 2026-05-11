@extends('layouts.app')
@section('title', 'Tambah Siswa')

@section('content')
<div class="flex items-center gap-3 mb-5">
    <div>
        <div class="text-xl font-bold text-gray-900">Tambah Siswa</div>
        <div class="text-sm text-gray-500 mt-0.5">Tambah data siswa baru</div>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
    <div class="bg-slate-50 px-6 py-4 border-b border-gray-100">
        <div class="text-base font-bold text-gray-900">Form Tambah Siswa</div>
        <div class="text-sm text-gray-500 mt-1">Isi data siswa dengan lengkap dan benar</div>
    </div>
    <div class="p-6">

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 px-4 py-3 rounded-lg text-sm mb-5">
                ✕ {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('siswa.store') }}">
            @csrf

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap Siswa</label>
                <input type="text" name="nama" value="{{ old('nama') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm text-gray-900 outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10 transition-all bg-white" placeholder="Masukkan nama lengkap">
                <div class="text-xs text-gray-500 mt-1.5">Nama sesuai dokumen resmi</div>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas</label>
                <select name="kelas_id" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm text-gray-900 outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10 transition-all bg-white">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }} — {{ $k->tahun_ajaran }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-3 pt-4 border-t border-slate-100 mt-4">
                <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold border-none cursor-pointer transition-colors">
                    <i class="ti ti-check text-sm" aria-hidden="true"></i> Simpan Siswa
                </button>
                <a href="{{ route('siswa.index') }}" class="inline-flex items-center gap-2 bg-gray-50 hover:bg-gray-100 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-semibold border border-gray-200 no-underline transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection