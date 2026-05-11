@extends('layouts.app')
@section('title', 'Detail Transaksi')

@section('content')
<style>
.page-title{font-size:20px;font-weight:600;color:#1e293b}
.page-sub{font-size:13px;color:#64748b;margin-top:2px}
.btn-secondary{display:inline-flex;align-items:center;gap:6px;background:#fff;color:#64748b;padding:10px 20px;border-radius:10px;font-size:13px;font-weight:500;border:1px solid #e2e8f0;text-decoration:none}
.card{background:#fff;border-radius:14px;border:1px solid #e2e8f0;overflow:hidden;max-width:600px;}
.card-header{padding:16px 20px;border-bottom:1px solid #f1f5f9;background:#fafbff}
.row-info{display:flex;padding:13px 20px;border-bottom:1px solid #f8fafc;font-size:13px;}
.row-info:last-child{border-bottom:none}
.row-label{color:#94a3b8;width:160px;flex-shrink:0;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:.04em;padding-top:1px}
.row-value{color:#1e293b;font-weight:500}
.badge-tabung{background:#d1fae5;color:#065f46;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;border:1px solid #a7f3d0}
.badge-tarik{background:#ffe4e6;color:#9f1239;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;border:1px solid #fecdd3}
</style>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
    <div>
        <div class="page-title">Detail Transaksi</div>
        <div class="page-sub">#{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}</div>
    </div>
    <a href="{{ route('transaksi.index') }}" class="btn-secondary">
        <i class="ti ti-arrow-left" aria-hidden="true"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <div style="font-size:14px;font-weight:600;color:#1e293b;">Informasi Transaksi</div>
    </div>

    <div class="row-info">
        <div class="row-label">ID Transaksi</div>
        <div class="row-value">#{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}</div>
    </div>
    <div class="row-info">
        <div class="row-label">Tanggal</div>
        <div class="row-value">{{ $transaksi->created_at->format('d F Y, H:i') }} WIB</div>
    </div>
    <div class="row-info">
        <div class="row-label">Siswa</div>
        <div class="row-value">
            {{ $transaksi->siswa->nama }}
        </div>
    </div>
    <div class="row-info">
        <div class="row-label">Kelas</div>
        <div class="row-value">{{ $transaksi->siswa->kelas->nama_kelas }}</div>
    </div>
    <div class="row-info">
        <div class="row-label">Jenis</div>
        <div class="row-value">
            @if($transaksi->jenis === 'tabung')
                <span class="badge-tabung">↑ Setor Tabungan</span>
            @else
                <span class="badge-tarik">↓ Tarik Tabungan</span>
            @endif
        </div>
    </div>
    <div class="row-info">
        <div class="row-label">Jumlah</div>
        <div class="row-value" style="font-size:16px;font-weight:700;{{ $transaksi->jenis === 'tabung' ? 'color:#065f46' : 'color:#9f1239' }}">
            {{ $transaksi->jenis === 'tabung' ? '+' : '-' }}Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}
        </div>
    </div>
    <div class="row-info">
        <div class="row-label">Saldo Sebelum</div>
        <div class="row-value">Rp {{ number_format($transaksi->saldo_sebelum, 0, ',', '.') }}</div>
    </div>
    <div class="row-info">
        <div class="row-label">Saldo Sesudah</div>
        <div class="row-value" style="font-weight:700;">Rp {{ number_format($transaksi->saldo_sesudah, 0, ',', '.') }}</div>
    </div>
    <div class="row-info">
        <div class="row-label">Dicatat Oleh</div>
        <div class="row-value">{{ $transaksi->user->name }}</div>
    </div>
    <div class="row-info">
        <div class="row-label">Keterangan</div>
        <div class="row-value" style="color:{{ $transaksi->keterangan ? '#1e293b' : '#94a3b8' }}">
            {{ $transaksi->keterangan ?? '—' }}
        </div>
    </div>
</div>
@endsection