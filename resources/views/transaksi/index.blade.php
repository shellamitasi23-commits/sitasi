@extends('layouts.app')
@section('title', 'Data Transaksi')

@section('content')
<style>
.page-title{font-size:20px;font-weight:600;color:#1e293b}
.page-sub{font-size:13px;color:#64748b;margin-top:2px}
.btn-primary{display:inline-flex;align-items:center;gap:6px;background:#2563eb;color:#fff;padding:10px 18px;border-radius:10px;font-size:13px;font-weight:500;text-decoration:none;border:none;cursor:pointer;transition:background .15s}
.btn-primary:hover{background:#1d4ed8}
.card{background:#fff;border-radius:14px;border:1px solid #e2e8f0;overflow:hidden}
.card-header{padding:16px 20px;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center;background:#fafbff}
.card-header-title{font-size:14px;font-weight:600;color:#1e293b}
.card-header-sub{font-size:12px;color:#94a3b8;margin-top:1px}
.tbl{width:100%;border-collapse:collapse}
.tbl thead tr{background:#f8fafc}
.tbl th{padding:11px 20px;text-align:left;font-size:12px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:0.04em;border-bottom:1px solid #f1f5f9}
.tbl td{padding:13px 20px;font-size:13px;color:#334155;border-bottom:1px solid #f8fafc}
.tbl tr:last-child td{border-bottom:none}
.tbl tbody tr:hover td{background:#f8faff}
.badge-tabung{background:#d1fae5;color:#065f46;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;border:1px solid #a7f3d0}
.badge-tarik{background:#ffe4e6;color:#9f1239;padding:4px 10px;border-radius:20px;font-size:11px;font-weight:600;border:1px solid #fecdd3}
.btn-detail{display:inline-flex;align-items:center;gap:4px;background:#eff6ff;color:#2563eb;padding:6px 12px;border-radius:8px;font-size:12px;font-weight:500;border:1px solid #bfdbfe;text-decoration:none}
.btn-hapus{display:inline-flex;align-items:center;gap:4px;background:#fff1f2;color:#e11d48;padding:6px 12px;border-radius:8px;font-size:12px;font-weight:500;border:1px solid #fecdd3;cursor:pointer;background-color:#fff1f2}
.alert-success{background:#d1fae5;border-left:4px solid #10b981;color:#065f46;padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px}
.alert-error{background:#ffe4e6;border-left:4px solid #e11d48;color:#9f1239;padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px}
.filter-card{background:#fff;border-radius:14px;border:1px solid #e2e8f0;padding:16px 20px;margin-bottom:16px}
.filter-select{border:1px solid #e2e8f0;border-radius:8px;padding:7px 12px;font-size:13px;color:#334155;background:#fff;outline:none;cursor:pointer}
.filter-select:focus{border-color:#2563eb}
.stat-box{background:#fff;border-radius:12px;border:1px solid #e2e8f0;padding:14px 18px;flex:1}
.stat-label{font-size:11px;color:#94a3b8;text-transform:uppercase;letter-spacing:.04em;font-weight:600}
.stat-value{font-size:18px;font-weight:700;margin-top:4px}
.amount-tabung{color:#065f46;font-weight:600}
.amount-tarik{color:#9f1239;font-weight:600}
</style>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
    <div>
        <div class="page-title">Data Transaksi</div>
        <div class="page-sub">Riwayat setor dan tarik tabungan siswa</div>
    </div>
    @if(Auth::user()->role === 'bendahara')
        <a href="{{ route('transaksi.create') }}" class="btn-primary">
            <i class="ti ti-plus" aria-hidden="true"></i> Tambah Transaksi
        </a>
    @endif
</div>

@if(session('success'))
    <div class="alert-success">✓ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert-error">✕ {{ session('error') }}</div>
@endif

{{-- Filter --}}
<div class="filter-card">
    <form method="GET" action="{{ route('transaksi.index') }}" style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end;">
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
            <div style="font-size:11px;color:#64748b;margin-bottom:4px;font-weight:500;">JENIS</div>
            <select name="jenis" class="filter-select">
                <option value="">Semua</option>
                <option value="tabung" {{ request('jenis') === 'tabung' ? 'selected' : '' }}>Setor</option>
                <option value="tarik" {{ request('jenis') === 'tarik' ? 'selected' : '' }}>Tarik</option>
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
                @foreach(range(date('Y'), 2020) as $y)
                    <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-primary" style="height:36px;padding:0 16px;">
            <i class="ti ti-filter" aria-hidden="true"></i> Filter
        </button>
        @if(request()->hasAny(['siswa_id','jenis','bulan','tahun']))
            <a href="{{ route('transaksi.index') }}" style="display:inline-flex;align-items:center;gap:4px;height:36px;padding:0 14px;border:1px solid #e2e8f0;border-radius:10px;font-size:13px;color:#64748b;text-decoration:none;">
                <i class="ti ti-x" aria-hidden="true"></i> Reset
            </a>
        @endif
    </form>
</div>

{{-- Stat ringkasan --}}
<div style="display:flex;gap:12px;margin-bottom:16px;">
    <div class="stat-box">
        <div class="stat-label">Total Transaksi</div>
        <div class="stat-value" style="color:#1e293b;">{{ $transaksi->total() }}</div>
    </div>
    <div class="stat-box">
        <div class="stat-label">Total Setor</div>
        <div class="stat-value amount-tabung">Rp {{ number_format($transaksi->getCollection()->where('jenis','tabung')->sum('jumlah'), 0, ',', '.') }}</div>
    </div>
    <div class="stat-box">
        <div class="stat-label">Total Tarik</div>
        <div class="stat-value amount-tarik">Rp {{ number_format($transaksi->getCollection()->where('jenis','tarik')->sum('jumlah'), 0, ',', '.') }}</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div>
            <div class="card-header-title">Riwayat Transaksi</div>
            <div class="card-header-sub">Menampilkan {{ $transaksi->firstItem() }}–{{ $transaksi->lastItem() }} dari {{ $transaksi->total() }} transaksi</div>
        </div>
    </div>
    <table class="tbl">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Siswa</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Saldo Sesudah</th>
                <th>Dicatat Oleh</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $i => $t)
            <tr>
                <td style="color:#94a3b8;font-size:12px;">{{ str_pad($transaksi->firstItem() + $i, 2, '0', STR_PAD_LEFT) }}</td>
                <td style="font-size:12px;color:#64748b;">
                    {{ $t->created_at->format('d M Y') }}<br>
                    <span style="color:#94a3b8;">{{ $t->created_at->format('H:i') }}</span>
                </td>
                <td>
                    <div style="font-weight:600;color:#1e293b;">{{ $t->siswa->nama }}</div>
                    <div style="font-size:11px;color:#94a3b8;">{{ $t->siswa->kelas->nama_kelas }}</div>
                </td>
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
                <td style="font-weight:600;color:#1e293b;">
                    Rp {{ number_format($t->saldo_sesudah, 0, ',', '.') }}
                </td>
                <td style="font-size:12px;color:#64748b;">{{ $t->user->name }}</td>
                <td>
                    <div style="display:flex;gap:6px;">
                        <a href="{{ route('transaksi.show', $t) }}" class="btn-detail">
                            <i class="ti ti-eye" style="font-size:12px;" aria-hidden="true"></i> Detail
                        </a>
                        @if(Auth::user()->role === 'bendahara')
                            <form method="POST" action="{{ route('transaksi.destroy', $t) }}"
                                  onsubmit="return confirm('Yakin hapus transaksi ini? Saldo siswa akan disesuaikan.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-hapus">
                                    <i class="ti ti-trash" style="font-size:12px;" aria-hidden="true"></i> Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="padding:40px;text-align:center;color:#94a3b8;font-size:13px;">
                    Belum ada data transaksi.
                    @if(Auth::user()->role === 'bendahara')
                        <a href="{{ route('transaksi.create') }}" style="color:#2563eb;">Buat transaksi</a>
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    @if($transaksi->hasPages())
    <div style="padding:16px 20px;border-top:1px solid #f1f5f9;display:flex;justify-content:flex-end;">
        {{ $transaksi->links() }}
    </div>
    @endif
</div>
@endsection