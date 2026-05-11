@extends('layouts.app')
@section('title', 'Data Kelas')

@section('content')
<style>
.page-title { font-size:20px; font-weight:600; color:#1e293b; }
.page-sub { font-size:13px; color:#64748b; margin-top:2px; }
.btn-primary { display:inline-flex; align-items:center; gap:6px; background:#2563eb; color:#fff; padding:10px 18px; border-radius:10px; font-size:13px; font-weight:500; text-decoration:none; border:none; cursor:pointer; }
.card { background:#fff; border-radius:14px; border:1px solid #e2e8f0; overflow:hidden; }
.card-header { padding:16px 20px; border-bottom:1px solid #f1f5f9; display:flex; justify-content:space-between; align-items:center; background:#fafbff; }
.card-header-title { font-size:14px; font-weight:600; color:#1e293b; }
.card-header-sub { font-size:12px; color:#94a3b8; margin-top:1px; }
.tbl { width:100%; border-collapse:collapse; }
.tbl thead tr { background:#f8fafc; }
.tbl th { padding:11px 20px; text-align:left; font-size:12px; color:#64748b; font-weight:600; text-transform:uppercase; letter-spacing:0.04em; border-bottom:1px solid #f1f5f9; }
.tbl td { padding:13px 20px; font-size:13px; color:#334155; border-bottom:1px solid #f8fafc; }
.tbl tr:last-child td { border-bottom:none; }
.tbl tbody tr:hover td { background:#f8faff; }
.kelas-badge { display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px; border-radius:10px; background:#dbeafe; color:#1d4ed8; font-size:13px; font-weight:700; }
.siswa-pill { display:inline-flex; align-items:center; gap:5px; background:#eff6ff; color:#1d4ed8; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:500; }
.tahun-pill { background:#fef9c3; color:#854d0e; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:500; }
.btn-edit { display:inline-flex; align-items:center; gap:4px; background:#f0fdf4; color:#16a34a; padding:6px 12px; border-radius:8px; font-size:12px; font-weight:500; border:1px solid #bbf7d0; text-decoration:none; }
.btn-hapus { display:inline-flex; align-items:center; gap:4px; background:#fff1f2; color:#e11d48; padding:6px 12px; border-radius:8px; font-size:12px; font-weight:500; border:1px solid #fecdd3; cursor:pointer; background-color:#fff1f2; }
.alert-success { background:#d1fae5; border-left:4px solid #10b981; color:#065f46; padding:12px 16px; border-radius:10px; font-size:13px; margin-bottom:16px; }
.alert-error { background:#ffe4e6; border-left:4px solid #e11d48; color:#9f1239; padding:12px 16px; border-radius:10px; font-size:13px; margin-bottom:16px; }
</style>

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <div>
        <div class="page-title">Data Kelas</div>
        <div class="page-sub">Kelola data kelas siswa TK</div>
    </div>
    @if(Auth::user()->role === 'bendahara')
        <a href="{{ route('kelas.create') }}" class="btn-primary">
            <i class="ti ti-plus" aria-hidden="true"></i> Tambah Kelas
        </a>
    @endif
</div>

@if(session('success'))
    <div class="alert-success">✓ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert-error">✕ {{ session('error') }}</div>
@endif

<div class="card">
    <div class="card-header">
        <div>
            <div class="card-header-title">Daftar Kelas</div>
            <div class="card-header-sub">Total {{ $kelas->count() }} kelas terdaftar</div>
        </div>
    </div>
    <table class="tbl">
        <thead>
            <tr>
                <th>No</th>
                <th>Kelas</th>
                <th>Tahun Ajaran</th>
                <th>Jumlah Siswa</th>
                @if(Auth::user()->role === 'bendahara')
                    <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($kelas as $i => $item)
            <tr>
                <td style="color:#94a3b8; font-size:12px;">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</td>
                <td>
                    <div style="display:flex; align-items:center; gap:10px;">
                        <div class="kelas-badge">{{ $item->nama_kelas }}</div>
                        <span style="font-weight:600; color:#1e293b;">Kelas {{ $item->nama_kelas }}</span>
                    </div>
                </td>
                <td><span class="tahun-pill">{{ $item->tahun_ajaran }}</span></td>
                <td><span class="siswa-pill"><i class="ti ti-users" style="font-size:12px;" aria-hidden="true"></i> {{ $item->siswa_count }} siswa</span></td>
                @if(Auth::user()->role === 'bendahara')
                <td>
                    <div style="display:flex; gap:6px;">
                        <a href="{{ route('kelas.edit', $item) }}" class="btn-edit">
                            <i class="ti ti-edit" style="font-size:12px;" aria-hidden="true"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('kelas.destroy', $item) }}"
                              onsubmit="return confirm('Yakin hapus kelas {{ $item->nama_kelas }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-hapus">
                                <i class="ti ti-trash" style="font-size:12px;" aria-hidden="true"></i> Hapus
                            </button>
                        </form>
                    </div>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="{{ Auth::user()->role === 'bendahara' ? 5 : 4 }}"
                    style="padding:40px; text-align:center; color:#94a3b8; font-size:13px;">
                    Belum ada data kelas. 
                    @if(Auth::user()->role === 'bendahara')
                        <a href="{{ route('kelas.create') }}" style="color:#2563eb;">Tambah sekarang</a>
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection