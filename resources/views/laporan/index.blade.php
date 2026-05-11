@extends('layouts.app')
@section('title', 'Laporan Tabungan')

@section('content')
<style>
.page-title{font-size:20px;font-weight:600;color:#1e293b}
.page-sub{font-size:13px;color:#64748b;margin-top:2px}
.btn-primary{display:inline-flex;align-items:center;gap:6px;background:#2563eb;color:#fff;padding:10px 18px;border-radius:10px;font-size:13px;font-weight:500;border:none;cursor:pointer;text-decoration:none}
.btn-export{display:inline-flex;align-items:center;gap:6px;background:#dc2626;color:#fff;padding:10px 18px;border-radius:10px;font-size:13px;font-weight:500;border:none;cursor:pointer;text-decoration:none}
.card{background:#fff;border-radius:14px;border:1px solid #e2e8f0;overflow:hidden}
.card-header{padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center;background:#fafbff}
.tbl{width:100%;border-collapse:collapse}
.tbl thead tr{background:#f8fafc}
.tbl th{padding:11px 20px;text-align:left;font-size:12px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.04em;border-bottom:1px solid #f1f5f9}
.tbl td{padding:13px 20px;font-size:13px;color:#334155;border-bottom:1px solid #f8fafc}
.tbl tr:last-child td{border-bottom:none}
.tbl tbody tr:hover td{background:#f8faff}
.badge-tabung{background:#d1fae5;color:#065f46;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;border:1px solid #a7f3d0}
.badge-tarik{background:#ffe4e6;color:#9f1239;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;border:1px solid #fecdd3}
.filter-card{background:#fff;border-radius:14px;border:1px solid #e2e8f0;padding:16px 20px;margin-bottom:16px}
.filter-select{border:1px solid #e2e8f0;border-radius:8px;padding:7px 12px;font-size:13px;color:#334155;background:#fff;outline:none;cursor:pointer}
.filter-select:focus{border-color:#2563eb}
.stat-box{background:#fff;border-radius:12px;border:1px solid #e2e8f0;padding:14px 18px;flex:1}
.stat-label{font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:.04em;font-weight:600}
.stat-value{font-size:18px;font-weight:700;margin-top:4px}
</style>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
    <div>
        <div class="page-title">Laporan Tabungan</div>
        <div class="page-sub">Rekap transaksi berdasarkan filter yang dipilih</div>
    </div>
    {{-- Tombol export dengan query string filter yang sama --}}
    <a href="{{ route('laporan.export', request()->query()) }}" class="btn-export">
        <i class="ti ti-file-type-pdf" aria-hidden="true"></i> Export PDF
    </a>
</div>

{{-- Filter --}}
<div class="filter-card">
    <form method="GET" action="{{ route('laporan.index') }}" style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end;">
        <div>
            <div style="font-size:11px;color:#64748b;margin-bottom:4px;font-weight:500;">KELAS</div>
            <select name="kelas_id" class="filter-select">
                <option value="">Semua Kelas</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <div style="font-size:11px;color:#64748b;margin-bottom:4px;font-weight:500;">SISWA</div>
            <select name="siswa_id" class="filter-select">
                <option value="">Semua Siswa</option>
                @foreach($siswaList as $s)
                    <option value="{{ $s->id }}" {{ request('siswa_id') == $s->id ? 'selected' : '' }}>
                        {{ $s->nama }} ({{ $s->kelas->nama_kelas }})
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <div style="font-size:11px;color:#64748b;margin-bottom:4px;font-weight:500;">BULAN</div>
            <select name="bulan" class="filter-select">
                <option value="">Semua Bulan</option>
                @foreach(['1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $num => $nama)
                    <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>{{ $nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <div style="font-size:11px;color:#64748b;margin-bottom:4px;font-weight:500;">TAHUN</div>
            <select name="tahun" class="filter-select">
                <option value="">Semua Tahun</option>
                @foreach($tahunList as $y)
                    <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-primary" style="height:36px;padding:0 16px;">
            <i class="ti ti-filter" aria-hidden="true"></i> Tampilkan
        </button>
        @if(request()->hasAny(['siswa_id','kelas_id','bulan','tahun']))
            <a href="{{ route('laporan.index') }}" style="display:inline-flex;align-items:center;gap:4px;height:36px;padding:0 14px;border:1px solid #e2e8f0;border-radius:10px;font-size:13px;color:#64748b;text-decoration:none;">
                <i class="ti ti-x" aria-hidden="true"></i> Reset
            </a>
        @endif
    </form>
</div>

{{-- Ringkasan --}}
<div style="display:flex;gap:12px;margin-bottom:16px;">
    <div class="stat-box">
        <div class="stat-label">Total Transaksi</div>
        <div class="stat-value" style="color:#1e293b;">{{ $transaksi->count() }}</div>
    </div>
    <div class="stat-box">
        <div class="stat-label">Total Setor</div>
        <div class="stat-value" style="color:#065f46;">Rp {{ number_format($totalTabung, 0, ',', '.') }}</div>
    </div>
    <div class="stat-box">
        <div class="stat-label">Total Tarik</div>
        <div class="stat-value" style="color:#9f1239;">Rp {{ number_format($totalTarik, 0, ',', '.') }}</div>
    </div>
    <div class="stat-box">
        <div class="stat-label">Selisih (Net)</div>
        <div class="stat-value" style="color:{{ $totalNet >= 0 ? '#065f46' : '#9f1239' }};">
            Rp {{ number_format(abs($totalNet), 0, ',', '.') }}
            <span style="font-size:12px;font-weight:400;">{{ $totalNet >= 0 ? '(surplus)' : '(defisit)' }}</span>
        </div>
    </div>
</div>

{{-- Tabel --}}
<div class="card">
    <div class="card-header">
        <div>
            <div style="font-size:14px;font-weight:600;color:#1e293b;">Rincian Transaksi</div>
            <div style="font-size:12px;color:#94a3b8;margin-top:1px;">{{ $transaksi->count() }} transaksi ditemukan</div>
        </div>
    </div>
    <table class="tbl">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Siswa</th>
                <th>Kelas</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Saldo Sesudah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $i => $t)
            <tr>
                <td style="color:#94a3b8;font-size:12px;">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</td>
                <td style="font-size:12px;color:#64748b;">{{ $t->created_at->format('d M Y') }}</td>
                <td>
                    <div style="font-weight:600;color:#1e293b;">{{ $t->siswa->nama }}</div>
                </td>
                <td style="font-size:12px;">{{ $t->siswa->kelas->nama_kelas }}</td>
                <td>
                    @if($t->jenis === 'tabung')
                        <span class="badge-tabung">↑ Setor</span>
                    @else
                        <span class="badge-tarik">↓ Tarik</span>
                    @endif
                </td>
                <td>
                    <span style="{{ $t->jenis === 'tabung' ? 'color:#065f46' : 'color:#9f1239' }};font-weight:600;">
                        {{ $t->jenis === 'tabung' ? '+' : '-' }}Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                    </span>
                </td>
                <td style="font-weight:600;">Rp {{ number_format($t->saldo_sesudah, 0, ',', '.') }}</td>
                <td style="color:#64748b;font-size:12px;">{{ $t->keterangan ?? '—' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="padding:40px;text-align:center;color:#94a3b8;font-size:13px;">
                    Tidak ada data transaksi untuk filter yang dipilih.
                </td>
            </tr>
            @endforelse
        </tbody>
        @if($transaksi->count() > 0)
        <tfoot>
            <tr style="background:#f8fafc;">
                <td colspan="5" style="padding:12px 20px;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;">Total</td>
                <td style="padding:12px 20px;font-weight:700;color:#1e293b;font-size:13px;">
                    <span style="color:#065f46;">+Rp {{ number_format($totalTabung, 0, ',', '.') }}</span><br>
                    <span style="color:#9f1239;">-Rp {{ number_format($totalTarik, 0, ',', '.') }}</span>
                </td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>
@endsection