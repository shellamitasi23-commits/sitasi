@extends('layouts.app')
@section('title', 'Data Transaksi')

@section('content')

<div class="flex justify-between items-center mb-5">
    <div>
        <div class="text-xl font-semibold text-slate-800">Data Transaksi</div>
        <div class="text-sm text-slate-500 mt-0.5">Riwayat setor dan tarik tabungan siswa</div>
    </div>
    @if(Auth::user()->role === 'bendahara')
        <a href="{{ route('transaksi.create') }}" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors">
            <i class="ti ti-plus" aria-hidden="true"></i> Tambah Transaksi
        </a>
    @endif
</div>

@if(session('success'))
    <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 px-4 py-3 rounded-lg text-sm mb-4">✓ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="bg-rose-100 border-l-4 border-rose-500 text-rose-800 px-4 py-3 rounded-lg text-sm mb-4">✕ {{ session('error') }}</div>
@endif

{{-- Filter --}}
<div class="bg-white rounded-xl border border-slate-200 p-5 mb-4 shadow-sm">
    <form method="GET" action="{{ route('transaksi.index') }}" class="flex gap-3 flex-wrap items-end">
        <div>
            <div class="text-xs text-slate-500 mb-1 font-medium">SISWA</div>
            <select name="siswa_id" class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 bg-white outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                <option value="">Semua Siswa</option>
                @foreach($siswaList as $s)
                    <option value="{{ $s->id }}" {{ request('siswa_id') == $s->id ? 'selected' : '' }}>
                        {{ $s->nama }} ({{ $s->kelas->nama_kelas }})
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <div class="text-xs text-slate-500 mb-1 font-medium">JENIS</div>
            <select name="jenis" class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 bg-white outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                <option value="">Semua</option>
                <option value="tabung" {{ request('jenis') === 'tabung' ? 'selected' : '' }}>Setor</option>
                <option value="tarik" {{ request('jenis') === 'tarik' ? 'selected' : '' }}>Tarik</option>
            </select>
        </div>
        <div>
            <div class="text-xs text-slate-500 mb-1 font-medium">BULAN</div>
            <select name="bulan" class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 bg-white outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                <option value="">Semua Bulan</option>
                @foreach(['1'=>'Januari','2'=>'Februari','3'=>'Maret','4'=>'April','5'=>'Mei','6'=>'Juni','7'=>'Juli','8'=>'Agustus','9'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'] as $num => $nama)
                    <option value="{{ $num }}" {{ request('bulan') == $num ? 'selected' : '' }}>{{ $nama }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <div class="text-xs text-slate-500 mb-1 font-medium">TAHUN</div>
            <select name="tahun" class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 bg-white outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                <option value="">Semua Tahun</option>
                @foreach(range(date('Y'), 2020) as $y)
                    <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white h-[38px] px-4 rounded-lg text-sm font-medium transition-colors">
            <i class="ti ti-filter" aria-hidden="true"></i> Filter
        </button>
        @if(request()->hasAny(['siswa_id','jenis','bulan','tahun']))
            <a href="{{ route('transaksi.index') }}" class="inline-flex items-center gap-1.5 h-[38px] px-3.5 border border-slate-200 hover:bg-slate-50 rounded-lg text-sm text-slate-500 transition-colors">
                <i class="ti ti-x" aria-hidden="true"></i> Reset
            </a>
        @endif
    </form>
</div>

{{-- Stat ringkasan --}}
<div class="flex gap-3 mb-4">
    <div class="bg-white rounded-xl border border-slate-200 p-4 flex-1 shadow-sm">
        <div class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Total Transaksi</div>
        <div class="text-lg font-bold mt-1 text-slate-800">{{ $transaksi->total() }}</div>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-4 flex-1 shadow-sm">
        <div class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Total Setor</div>
        <div class="text-lg font-bold mt-1 text-emerald-800">Rp {{ number_format($transaksi->getCollection()->where('jenis','tabung')->sum('jumlah'), 0, ',', '.') }}</div>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-4 flex-1 shadow-sm">
        <div class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Total Tarik</div>
        <div class="text-lg font-bold mt-1 text-rose-800">Rp {{ number_format($transaksi->getCollection()->where('jenis','tarik')->sum('jumlah'), 0, ',', '.') }}</div>
    </div>
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
    <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
        <div>
            <div class="text-sm font-semibold text-slate-800">Riwayat Transaksi</div>
            <div class="text-xs text-slate-500 mt-0.5">Menampilkan {{ $transaksi->firstItem() }}–{{ $transaksi->lastItem() }} dari {{ $transaksi->total() }} transaksi</div>
        </div>
    </div>
         {{-- Search --}}
    <form action="{{ route('kelas.index') }}" method="GET" class="flex-1 flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-lg px-5 h-10 m-2">
        <i class="ti ti-search text-slate-400 text-base shrink-0" aria-hidden="true"></i>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa atau kelas..." 
               class="border-none bg-transparent outline-none text-sm text-slate-700 w-full placeholder:text-slate-400 focus:ring-0">
    </form>
    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">No</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Tanggal</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Siswa</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Jenis</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Jumlah</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Saldo Sesudah</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Dicatat Oleh</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksi as $i => $t)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-5 py-3 text-sm text-slate-500 border-b border-slate-50">{{ str_pad($transaksi->firstItem() + $i, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-5 py-3 text-xs text-slate-500 border-b border-slate-50">
                        {{ $t->created_at->translatedFormat('d M Y') }}<br>
                        <span class="text-slate-400">{{ $t->created_at->translatedFormat('H:i') }}</span>
                    </td>
                    <td class="px-5 py-3 border-b border-slate-50">
                        <div class="font-semibold text-slate-800 text-sm">{{ $t->siswa->nama }}</div>
                        <div class="text-xs text-slate-500">{{ $t->siswa->kelas->nama_kelas }}</div>
                    </td>
                    <td class="px-5 py-3 text-sm border-b border-slate-50">
                        @if($t->jenis === 'tabung')
                            <span class="bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-full text-xs font-semibold border border-emerald-200">Setor</span>
                        @else
                            <span class="bg-rose-100 text-rose-800 px-2.5 py-1 rounded-full text-xs font-semibold border border-rose-200">Tarik</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-sm border-b border-slate-50">
                        <span class="{{ $t->jenis === 'tabung' ? 'text-emerald-800' : 'text-rose-800' }} font-semibold">
                            {{ $t->jenis === 'tabung' ? '+' : '-' }}Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-sm text-slate-800 font-semibold border-b border-slate-50">
                        Rp {{ number_format($t->saldo_sesudah, 0, ',', '.') }}
                    </td>
                    <td class="px-5 py-3 text-xs text-slate-500 border-b border-slate-50">{{ $t->user->name }}</td>
                    <td class="px-5 py-3 border-b border-slate-50">
                        <div class="flex gap-2">
                            <a href="{{ route('transaksi.show', $t) }}" class="inline-flex items-center gap-1 bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-1.5 rounded-lg text-xs font-medium border border-blue-200 transition-colors">
                                <i class="ti ti-eye" aria-hidden="true"></i> Detail
                            </a>
                            @if(Auth::user()->role === 'bendahara')
                                <form method="POST" action="{{ route('transaksi.destroy', $t) }}"
                                      onsubmit="return confirm('Yakin hapus transaksi ini? Saldo siswa akan disesuaikan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 bg-rose-50 hover:bg-rose-100 text-rose-600 px-3 py-1.5 rounded-lg text-xs font-medium border border-rose-200 transition-colors">
                                        <i class="ti ti-trash" aria-hidden="true"></i> Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-5 py-10 text-center text-sm text-slate-500">
                        Belum ada data transaksi.
                        @if(Auth::user()->role === 'bendahara')
                            <a href="{{ route('transaksi.create') }}" class="text-blue-600 hover:underline">Buat transaksi</a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($transaksi->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 flex justify-end">
        {{ $transaksi->links() }}
    </div>
    @endif
</div>
@endsection