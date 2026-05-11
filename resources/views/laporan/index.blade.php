@extends('layouts.app')
@section('title', 'Laporan Tabungan')

@section('content')

<div class="flex justify-between items-center mb-5">
    <div>
        <div class="text-xl font-semibold text-slate-800">Laporan Tabungan</div>
        <div class="text-sm text-slate-500 mt-0.5">Rekap transaksi berdasarkan filter yang dipilih</div>
    </div>
    {{-- Tombol export dengan query string filter yang sama --}}
    <a href="{{ route('laporan.export', request()->query()) }}" class="inline-flex items-center gap-1.5 bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors">
        <i class="ti ti-file-type-pdf" aria-hidden="true"></i> Export PDF
    </a>
</div>

{{-- Filter --}}
<div class="bg-white rounded-xl border border-slate-200 p-5 mb-4 shadow-sm">
    <form method="GET" action="{{ route('laporan.index') }}" class="flex gap-3 flex-wrap items-end">
        <div>
            <div class="text-xs text-slate-500 mb-1 font-medium">KELAS</div>
            <select name="kelas_id" class="border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 bg-white outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600">
                <option value="">Semua Kelas</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>
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
                @foreach($tahunList as $y)
                    <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white h-[38px] px-4 rounded-lg text-sm font-medium transition-colors">
            <i class="ti ti-filter" aria-hidden="true"></i> Tampilkan
        </button>
        @if(request()->hasAny(['siswa_id','kelas_id','bulan','tahun']))
            <a href="{{ route('laporan.index') }}" class="inline-flex items-center gap-1.5 h-[38px] px-3.5 border border-slate-200 hover:bg-slate-50 rounded-lg text-sm text-slate-500 transition-colors">
                <i class="ti ti-x" aria-hidden="true"></i> Reset
            </a>
        @endif
    </form>
</div>

{{-- Ringkasan --}}
<div class="flex gap-3 mb-4">
    <div class="bg-white rounded-xl border border-slate-200 p-4 flex-1 shadow-sm">
        <div class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Total Transaksi</div>
        <div class="text-lg font-bold mt-1 text-slate-800">{{ $transaksi->count() }}</div>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-4 flex-1 shadow-sm">
        <div class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Total Setor</div>
        <div class="text-lg font-bold mt-1 text-emerald-800">Rp {{ number_format($totalTabung, 0, ',', '.') }}</div>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-4 flex-1 shadow-sm">
        <div class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Total Tarik</div>
        <div class="text-lg font-bold mt-1 text-rose-800">Rp {{ number_format($totalTarik, 0, ',', '.') }}</div>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-4 flex-1 shadow-sm">
        <div class="text-xs text-slate-400 uppercase tracking-wider font-semibold">Selisih (Net)</div>
        <div class="text-lg font-bold mt-1 {{ $totalNet >= 0 ? 'text-emerald-800' : 'text-rose-800' }}">
            Rp {{ number_format(abs($totalNet), 0, ',', '.') }}
            <span class="text-xs font-normal">{{ $totalNet >= 0 ? '(surplus)' : '(defisit)' }}</span>
        </div>
    </div>
</div>

{{-- Tabel --}}
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
    <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
        <div>
            <div class="text-sm font-semibold text-slate-800">Rincian Transaksi</div>
            <div class="text-xs text-slate-500 mt-0.5">{{ $transaksi->count() }} transaksi ditemukan</div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">No</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Tanggal</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Siswa</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Kelas</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Jenis</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Jumlah</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Saldo Sesudah</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksi as $i => $t)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-5 py-3 text-sm text-slate-500 border-b border-slate-50">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-5 py-3 text-xs text-slate-500 border-b border-slate-50">{{ $t->created_at->translatedFormat('d M Y') }}</td>
                    <td class="px-5 py-3 text-sm text-slate-800 font-medium border-b border-slate-50">
                        {{ $t->siswa->nama }}
                    </td>
                    <td class="px-5 py-3 text-xs text-slate-700 border-b border-slate-50">{{ $t->siswa->kelas->nama_kelas }}</td>
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
                    <td class="px-5 py-3 text-sm text-slate-800 font-semibold border-b border-slate-50">Rp {{ number_format($t->saldo_sesudah, 0, ',', '.') }}</td>
                    <td class="px-5 py-3 text-xs text-slate-500 border-b border-slate-50">{{ $t->keterangan ?? '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-5 py-10 text-center text-sm text-slate-500">
                        Tidak ada data transaksi untuk filter yang dipilih.
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($transaksi->count() > 0)
            <tfoot class="bg-slate-50">
                <tr>
                    <td colspan="5" class="px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Total</td>
                    <td class="px-5 py-3 text-sm font-bold text-slate-800">
                        <span class="text-emerald-800">+Rp {{ number_format($totalTabung, 0, ',', '.') }}</span><br>
                        <span class="text-rose-800">-Rp {{ number_format($totalTarik, 0, ',', '.') }}</span>
                    </td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection