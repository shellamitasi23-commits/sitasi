@extends('layouts.app')
@section('title', 'Data Siswa')

@section('content')

<div class="flex justify-between items-center mb-5">
    <div>
        <div class="text-xl font-semibold text-slate-800">Data Siswa</div>
        <div class="text-sm text-slate-500 mt-0.5">Kelola data siswa dan saldo tabungan</div>
    </div>
    @if(Auth::user()->role === 'bendahara')
        <a href="{{ route('siswa.create') }}" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors">
            <i class="ti ti-plus" aria-hidden="true"></i> Tambah Siswa
        </a>
    @endif
</div>

@if(session('success'))
    <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 px-4 py-3 rounded-lg text-sm mb-4">✓ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="bg-rose-100 border-l-4 border-rose-500 text-rose-800 px-4 py-3 rounded-lg text-sm mb-4">✕ {{ session('error') }}</div>
@endif

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
    <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
        <div>
            <div class="text-sm font-semibold text-slate-800">Daftar Siswa</div>
            <div class="text-xs text-slate-500 mt-0.5">Total {{ $siswa->count() }} siswa terdaftar</div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">No</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Nama Siswa</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Kelas</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Saldo</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswa as $i => $s)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-5 py-3 text-sm text-slate-500 border-b border-slate-50">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-5 py-3 border-b border-slate-50">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 text-xs font-bold flex items-center justify-center shrink-0">
                                {{ strtoupper(substr($s->nama ?? '-', 0, 2)) }}
                            </div>
                            <div class="font-semibold text-slate-800 text-sm">
                                {{ $s->nama }}
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3 border-b border-slate-50">
                        <span class="bg-emerald-50 text-emerald-600 px-2.5 py-1 rounded-full text-xs font-medium border border-emerald-200">
                            {{ $s->kelas?->nama_kelas ?? '-' }}
                        </span>
                    </td>
                    <td class="px-5 py-3 border-b border-slate-50">
                        <span class="font-semibold text-slate-800 text-sm">
                            Rp {{ number_format($s->saldo, 0, ',', '.') }}
                        </span>
                    </td>
                    <td class="px-5 py-3 border-b border-slate-50">
                        <div class="flex gap-2 flex-wrap">
                            <a href="{{ route('siswa.show', $s->id) }}" class="inline-flex items-center gap-1 bg-blue-50 hover:bg-blue-100 text-blue-600 px-3 py-1.5 rounded-lg text-xs font-medium border border-blue-200 transition-colors">
                                <i class="ti ti-eye" aria-hidden="true"></i> Detail
                            </a>
                            @if(Auth::user()->role === 'bendahara')
                                <a href="{{ route('siswa.edit', $s->id) }}" class="inline-flex items-center gap-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 px-3 py-1.5 rounded-lg text-xs font-medium border border-emerald-200 transition-colors">
                                    <i class="ti ti-edit" aria-hidden="true"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('siswa.destroy', $s->id) }}" onsubmit="return confirm('Yakin hapus siswa {{ $s->nama }}?')">
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
                    <td colspan="5" class="px-5 py-10 text-center text-sm text-slate-500">
                        Belum ada data siswa.
                        @if(Auth::user()->role === 'bendahara')
                            <br><br>
                            <a href="{{ route('siswa.create') }}" class="text-blue-600 hover:underline">Tambah sekarang</a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection