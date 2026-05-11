@extends('layouts.app')
@section('title', 'Detail Transaksi')

@section('content')

<div class="flex justify-between items-center mb-5">
    <div>
        <div class="text-xl font-semibold text-slate-800">Detail Transaksi</div>
        <div class="text-sm text-slate-500 mt-0.5">#{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}</div>
    </div>
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
    <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50">
        <div class="text-sm font-semibold text-slate-800">Informasi Transaksi</div>
    </div>

    <div class="flex px-5 py-3 border-b border-slate-50 text-sm">
        <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider w-40 shrink-0 pt-0.5">ID Transaksi</div>
        <div class="text-slate-800 font-medium">#{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}</div>
    </div>
    <div class="flex px-5 py-3 border-b border-slate-50 text-sm">
        <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider w-40 shrink-0 pt-0.5">Tanggal</div>
        <div class="text-slate-800 font-medium">{{ $transaksi->created_at->translatedFormat('d F Y, H:i') }} WIB</div>
    </div>
    <div class="flex px-5 py-3 border-b border-slate-50 text-sm">
        <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider w-40 shrink-0 pt-0.5">Siswa</div>
        <div class="text-slate-800 font-medium">
            {{ $transaksi->siswa->nama }}
        </div>
    </div>
    <div class="flex px-5 py-3 border-b border-slate-50 text-sm">
        <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider w-40 shrink-0 pt-0.5">Kelas</div>
        <div class="text-slate-800 font-medium">{{ $transaksi->siswa->kelas->nama_kelas }}</div>
    </div>
    <div class="flex px-5 py-3 border-b border-slate-50 text-sm">
        <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider w-40 shrink-0 pt-0.5">Jenis</div>
        <div>
            @if($transaksi->jenis === 'tabung')
                <span class="bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-xs font-semibold border border-emerald-200">↑ Setor Tabungan</span>
            @else
                <span class="bg-rose-100 text-rose-800 px-3 py-1 rounded-full text-xs font-semibold border border-rose-200">↓ Tarik Tabungan</span>
            @endif
        </div>
    </div>
    <div class="flex px-5 py-3 border-b border-slate-50 text-sm items-center">
        <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider w-40 shrink-0">Jumlah</div>
        <div class="text-base font-bold {{ $transaksi->jenis === 'tabung' ? 'text-emerald-800' : 'text-rose-800' }}">
            {{ $transaksi->jenis === 'tabung' ? '+' : '-' }}Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}
        </div>
    </div>
    <div class="flex px-5 py-3 border-b border-slate-50 text-sm">
        <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider w-40 shrink-0 pt-0.5">Saldo Sebelum</div>
        <div class="text-slate-800 font-medium">Rp {{ number_format($transaksi->saldo_sebelum, 0, ',', '.') }}</div>
    </div>
    <div class="flex px-5 py-3 border-b border-slate-50 text-sm">
        <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider w-40 shrink-0 pt-0.5">Saldo Sesudah</div>
        <div class="text-slate-800 font-bold">Rp {{ number_format($transaksi->saldo_sesudah, 0, ',', '.') }}</div>
    </div>
    <div class="flex px-5 py-3 border-b border-slate-50 text-sm">
        <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider w-40 shrink-0 pt-0.5">Dicatat Oleh</div>
        <div class="text-slate-800 font-medium">{{ $transaksi->user->name }}</div>
    </div>
    <div class="flex px-5 py-3 text-sm">
        <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider w-40 shrink-0 pt-0.5">Keterangan</div>
        <div class="{{ $transaksi->keterangan ? 'text-slate-800 font-medium' : 'text-slate-400' }}">
            {{ $transaksi->keterangan ?? '—' }}
        </div>
    </div>
</div>
@endsection