@extends('layouts.app')
@section('title', 'Detail Siswa')

@section('content')
<style>
.page-title{font-size:20px;font-weight:600;color:#1e293b}
.page-sub{font-size:13px;color:#64748b;margin-top:2px}
.grid-2{display:grid;grid-template-columns:1fr 2fr;gap:16px;align-items:start}
.card{background:#fff;border-radius:14px;border:1px solid #e2e8f0;overflow:hidden}
.card-header{padding:16px 20px;border-bottom:1px solid #f1f5f9;background:#fafbff}
.card-header-title{font-size:14px;font-weight:600;color:#1e293b}
.card-body{padding:20px}
.avatar-lg{width:64px;height:64px;border-radius:16px;background:#dbeafe;color:#1d4ed8;font-size:22px;font-weight:700;display:flex;align-items:center;justify-content:center;margin:0 auto 12px}
.info-row{display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid #f8fafc;font-size:13px}
.info-row:last-child{border-bottom:none}
.info-label{color:#64748b}
.info-value{font-weight:500;color:#1e293b}
.saldo-big{text-align:center;padding:16px 0;border-bottom:1px solid #f1f5f9}
.tbl{width:100%;border-collapse:collapse}
.tbl th{padding:10px 16px;text-align:left;font-size:12px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:0.04em;border-bottom:1px solid #f1f5f9;background:#f8fafc}
.tbl td{padding:12px 16px;font-size:13px;color:#334155;border-bottom:1px solid #f8fafc}
.tbl tr:last-child td{border-bottom:none}
.badge-tabung{background:#dcfce7;color:#16a34a;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:500}
.badge-tarik{background:#ffe4e6;color:#e11d48;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:500}
</style>

<div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
    <a href="{{ route('siswa.index') }}" 
       style="display:flex;align-items:center;justify-content:center;width:34px;height:34px;background:#fff;border:1px solid #e2e8f0;border-radius:8px;color:#64748b;text-decoration:none;">
        <i class="ti ti-arrow-left" style="font-size:16px;" aria-hidden="true"></i>
    </a>
    <div>
        <div class="page-title">Detail Siswa</div>
        <div class="page-sub">Informasi lengkap dan riwayat transaksi</div>
    </div>
</div>

<div class="grid-2">

    {{-- Kartu Profil --}}
    <div class="card">
        <div class="card-header">
            <div class="card-header-title">Profil Siswa</div>
        </div>
        <div class="card-body">
            <div class="avatar-lg">{{ strtoupper(substr($siswa->nama, 0, 2)) }}</div>
            <div style="text-align:center;margin-bottom:16px;">
                <div style="font-size:16px;font-weight:600;color:#1e293b;">{{ $siswa->nama }}</div>
            </div>

            <div class="saldo-big">
                <div style="font-size:12px;color:#64748b;margin-bottom:4px;">Total Saldo</div>
                <div style="font-size:24px;font-weight:700;color:#16a34a;">Rp {{ number_format($siswa->saldo, 0, ',', '.') }}</div>
            </div>

            <div style="margin-top:12px;">
                <div class="info-row">
                    <span class="info-label">Kelas</span>
                    <span class="info-value">{{ $siswa->kelas->nama_kelas }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tahun Ajaran</span>
                    <span class="info-value">{{ $siswa->kelas->tahun_ajaran }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Total Transaksi</span>
                    <span class="info-value">{{ $siswa->transaksi->count() }}x</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Terdaftar</span>
                    <span class="info-value">{{ $siswa->created_at->format('d M Y') }}</span>
                </div>
            </div>

            @if(Auth::user()->role === 'bendahara')
                <div style="margin-top:16px;display:flex;gap:8px;">
                    <a href="{{ route('siswa.edit', $siswa) }}" 
                       style="flex:1;text-align:center;background:#eff6ff;color:#2563eb;padding:9px;border-radius:8px;font-size:13px;font-weight:500;text-decoration:none;border:1px solid #bfdbfe;">
                        Edit Data
                    </a>
                    <a href="{{ route('transaksi.create', ['siswa_id' => $siswa->id]) }}" 
                       style="flex:1;text-align:center;background:#2563eb;color:#fff;padding:9px;border-radius:8px;font-size:13px;font-weight:500;text-decoration:none;">
                        + Transaksi
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Riwayat Transaksi --}}
    <div class="card">
        <div class="card-header">
            <div class="card-header-title">Riwayat Transaksi</div>
        </div>
        <table class="tbl">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Saldo Sesudah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswa->transaksi->sortByDesc('created_at') as $t)
                <tr>
                    <td style="color:#64748b;">{{ $t->created_at->format('d M Y') }}</td>
                    <td>
                        @if($t->jenis === 'tabung')
                            <span class="badge-tabung">Tabung</span>
                        @else
                            <span class="badge-tarik">Tarik</span>
                        @endif
                    </td>
                    <td style="font-weight:500;">Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($t->saldo_sesudah, 0, ',', '.') }}</td>
                    <td style="color:#64748b;">{{ $t->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding:32px;text-align:center;color:#94a3b8;font-size:13px;">
                        Belum ada riwayat transaksi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection