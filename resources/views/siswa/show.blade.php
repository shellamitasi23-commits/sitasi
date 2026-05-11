@extends('layouts.app')
@section('title', 'Detail Siswa')

@section('content')

<div class="flex items-center gap-3 mb-5">
    <a href="{{ route('siswa.index') }}" 
       class="flex items-center justify-center w-[34px] h-[34px] bg-white border border-slate-200 rounded-lg text-slate-500 hover:bg-slate-50 transition-colors">
        <i class="ti ti-arrow-left text-base" aria-hidden="true"></i>
    </a>
    <div>
        <div class="text-xl font-semibold text-slate-800">Detail Siswa</div>
        <div class="text-sm text-slate-500 mt-0.5">Informasi lengkap dan riwayat transaksi</div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">

    {{-- Kartu Profil --}}
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm col-span-1 md:col-span-1">
        <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50">
            <div class="text-sm font-semibold text-slate-800">Profil Siswa</div>
        </div>
        <div class="p-5">
            <div class="w-16 h-16 rounded-2xl bg-blue-100 text-blue-700 text-2xl font-bold flex items-center justify-center mx-auto mb-3">
                {{ strtoupper(substr($siswa->nama, 0, 2)) }}
            </div>
            <div class="text-center mb-4">
                <div class="text-base font-semibold text-slate-800">{{ $siswa->nama }}</div>
            </div>

            <div class="text-center py-4 border-b border-slate-100">
                <div class="text-xs text-slate-500 mb-1">Total Saldo</div>
                <div class="text-2xl font-bold text-emerald-600">Rp {{ number_format($siswa->saldo, 0, ',', '.') }}</div>
            </div>

            <div class="mt-3">
                <div class="flex justify-between items-center py-2.5 border-b border-slate-50 text-sm">
                    <span class="text-slate-500">Kelas</span>
                    <span class="font-medium text-slate-800">{{ $siswa->kelas->nama_kelas }}</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-50 text-sm">
                    <span class="text-slate-500">Tahun Ajaran</span>
                    <span class="font-medium text-slate-800">{{ $siswa->kelas->tahun_ajaran }}</span>
                </div>
                <div class="flex justify-between items-center py-2.5 border-b border-slate-50 text-sm">
                    <span class="text-slate-500">Total Transaksi</span>
                    <span class="font-medium text-slate-800">{{ $siswa->transaksi->count() }}x</span>
                </div>
                <div class="flex justify-between items-center py-2.5 text-sm">
                    <span class="text-slate-500">Terdaftar</span>
                    <span class="font-medium text-slate-800">{{ $siswa->created_at->translatedFormat('d M Y') }}</span>
                </div>
            </div>

            @if(Auth::user()->role === 'bendahara')
                <div class="mt-4 flex gap-2">
                    <a href="{{ route('siswa.edit', $siswa) }}" 
                       class="flex-1 text-center bg-blue-50 text-blue-600 py-2 px-3 rounded-lg text-sm font-medium border border-blue-200 hover:bg-blue-100 transition-colors">
                        Edit Data
                    </a>
                    <a href="{{ route('transaksi.create', ['siswa_id' => $siswa->id]) }}" 
                       class="flex-1 text-center bg-blue-600 text-white py-2 px-3 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                        + Transaksi
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Riwayat Transaksi --}}
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm col-span-1 md:col-span-2">
        <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50">
            <div class="text-sm font-semibold text-slate-800">Riwayat Transaksi</div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Tanggal</th>
                        <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Jenis</th>
                        <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Jumlah</th>
                        <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Saldo Sesudah</th>
                        <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa->transaksi->sortByDesc('created_at') as $t)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-5 py-3 text-sm text-slate-500 border-b border-slate-50">{{ $t->created_at->translatedFormat('d M Y') }}</td>
                        <td class="px-5 py-3 text-sm border-b border-slate-50">
                            @if($t->jenis === 'tabung')
                                <span class="bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-full text-xs font-semibold border border-emerald-200">Tabung</span>
                            @else
                                <span class="bg-rose-100 text-rose-800 px-2.5 py-1 rounded-full text-xs font-semibold border border-rose-200">Tarik</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-sm font-semibold text-slate-800 border-b border-slate-50">Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                        <td class="px-5 py-3 text-sm text-slate-700 border-b border-slate-50">Rp {{ number_format($t->saldo_sesudah, 0, ',', '.') }}</td>
                        <td class="px-5 py-3 text-sm text-slate-500 border-b border-slate-50">{{ $t->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-sm text-slate-400">
                            Belum ada riwayat transaksi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection