@extends('layouts.app')
@section('title', 'Data Siswa')

@section('content')

<style>
.page-title{
    font-size:20px;
    font-weight:600;
    color:#1e293b
}

.page-sub{
    font-size:13px;
    color:#64748b;
    margin-top:2px
}

.btn-primary{
    display:inline-flex;
    align-items:center;
    gap:6px;
    background:#2563eb;
    color:#fff;
    padding:10px 18px;
    border-radius:10px;
    font-size:13px;
    font-weight:500;
    text-decoration:none;
    border:none;
    cursor:pointer
}

.card{
    background:#fff;
    border-radius:14px;
    border:1px solid #e2e8f0;
    overflow:hidden
}

.card-header{
    padding:16px 20px;
    border-bottom:1px solid #f1f5f9;
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:#fafbff
}

.card-header-title{
    font-size:14px;
    font-weight:600;
    color:#1e293b
}

.card-header-sub{
    font-size:12px;
    color:#94a3b8;
    margin-top:1px
}

.tbl{
    width:100%;
    border-collapse:collapse
}

.tbl thead tr{
    background:#f8fafc
}

.tbl th{
    padding:11px 20px;
    text-align:left;
    font-size:12px;
    color:#64748b;
    font-weight:600;
    text-transform:uppercase;
    letter-spacing:0.04em;
    border-bottom:1px solid #f1f5f9
}

.tbl td{
    padding:13px 20px;
    font-size:13px;
    color:#334155;
    border-bottom:1px solid #f8fafc
}

.tbl tr:last-child td{
    border-bottom:none
}

.tbl tbody tr:hover td{
    background:#f8faff
}

.avatar{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    width:34px;
    height:34px;
    border-radius:10px;
    background:#dbeafe;
    color:#1d4ed8;
    font-size:12px;
    font-weight:700;
    flex-shrink:0
}

.kelas-pill{
    background:#f0fdf4;
    color:#16a34a;
    padding:4px 10px;
    border-radius:20px;
    font-size:12px;
    font-weight:500;
    border:1px solid #bbf7d0
}

.saldo-text{
    font-weight:600;
    color:#1e293b
}

.btn-detail{
    display:inline-flex;
    align-items:center;
    gap:4px;
    background:#eff6ff;
    color:#2563eb;
    padding:6px 12px;
    border-radius:8px;
    font-size:12px;
    font-weight:500;
    border:1px solid #bfdbfe;
    text-decoration:none
}

.btn-edit{
    display:inline-flex;
    align-items:center;
    gap:4px;
    background:#f0fdf4;
    color:#16a34a;
    padding:6px 12px;
    border-radius:8px;
    font-size:12px;
    font-weight:500;
    border:1px solid #bbf7d0;
    text-decoration:none
}

.btn-hapus{
    display:inline-flex;
    align-items:center;
    gap:4px;
    background:#fff1f2;
    color:#e11d48;
    padding:6px 12px;
    border-radius:8px;
    font-size:12px;
    font-weight:500;
    border:1px solid #fecdd3;
    cursor:pointer
}

.alert-success{
    background:#d1fae5;
    border-left:4px solid #10b981;
    color:#065f46;
    padding:12px 16px;
    border-radius:10px;
    font-size:13px;
    margin-bottom:16px
}

.alert-error{
    background:#ffe4e6;
    border-left:4px solid #e11d48;
    color:#9f1239;
    padding:12px 16px;
    border-radius:10px;
    font-size:13px;
    margin-bottom:16px
}
</style>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">

    <div>
        <div class="page-title">Data Siswa</div>
        <div class="page-sub">
            Kelola data siswa dan saldo tabungan
        </div>
    </div>

    @if(Auth::user()->role === 'bendahara')
        <a href="{{ route('siswa.create') }}" class="btn-primary">
            <i class="ti ti-plus"></i>
            Tambah Siswa
        </a>
    @endif

</div>

@if(session('success'))
    <div class="alert-success">
        ✓ {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert-error">
        ✕ {{ session('error') }}
    </div>
@endif

<div class="card">

    <div class="card-header">

        <div>
            <div class="card-header-title">
                Daftar Siswa
            </div>

            <div class="card-header-sub">
                Total {{ $siswa->count() }} siswa terdaftar
            </div>
        </div>

    </div>

    <table class="tbl">

        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Saldo</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

            @forelse($siswa as $i => $s)

                <tr>

                    <td style="color:#94a3b8;font-size:12px;">
                        {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                    </td>

                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">

                            <div class="avatar">
                                {{ strtoupper(substr($s->nama ?? '-', 0, 2)) }}
                            </div>

                            <div>
                                <div style="font-weight:600;color:#1e293b;">
                                    {{ $s->nama }}
                                </div>
                            </div>

                        </div>
                    </td>

                    <td>
                        <span class="kelas-pill">
                            {{ $s->kelas?->nama_kelas ?? '-' }}
                        </span>
                    </td>

                    <td>
                        <span class="saldo-text">
                            Rp {{ number_format($s->saldo, 0, ',', '.') }}
                        </span>
                    </td>

                    <td>

                        <div style="display:flex;gap:6px;flex-wrap:wrap;">

                            <a href="{{ route('siswa.show', $s->id) }}"
                               class="btn-detail">
                                <i class="ti ti-eye"></i>
                                Detail
                            </a>

                            @if(Auth::user()->role === 'bendahara')

                                <a href="{{ route('siswa.edit', $s->id) }}"
                                   class="btn-edit">
                                    <i class="ti ti-edit"></i>
                                    Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('siswa.destroy', $s->id) }}"
                                      onsubmit="return confirm('Yakin hapus siswa {{ $s->nama }}?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-hapus">
                                        <i class="ti ti-trash"></i>
                                        Hapus
                                    </button>

                                </form>

                            @endif

                        </div>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="5"
                        style="padding:40px;text-align:center;color:#94a3b8;font-size:13px;">

                        Belum ada data siswa.

                        @if(Auth::user()->role === 'bendahara')
                            <br><br>

                            <a href="{{ route('siswa.create') }}"
                               style="color:#2563eb;text-decoration:none;">
                                Tambah sekarang
                            </a>
                        @endif

                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection