@extends('layouts.app')
@section('title', 'Data Kelas')

@section('content')

<div class="flex justify-between items-center mb-5">
    <div>
        <div class="text-xl font-semibold text-slate-800">Data Kelas</div>
        <div class="text-sm text-slate-500 mt-0.5">Kelola data kelas siswa TK</div>
    </div>
    
    @if(Auth::user()->role === 'bendahara')
        <a href="{{ route('kelas.create') }}" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors">
            <i class="ti ti-plus" aria-hidden="true"></i> Tambah Kelas
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
            <div class="text-sm font-semibold text-slate-800">Daftar Kelas</div>
            <div class="text-xs text-slate-500 mt-0.5">Total {{ $kelas->count() }} kelas terdaftar</div>
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
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Kelas</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Tahun Ajaran</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Jumlah Siswa</th>
                    @if(Auth::user()->role === 'bendahara')
                        <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($kelas as $i => $item)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-5 py-3 text-sm text-slate-500 border-b border-slate-50">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-5 py-3 border-b border-slate-50">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center w-9 h-9 rounded-lg bg-blue-100 text-blue-700 text-sm font-bold">
                                {{ $item->nama_kelas }}
                            </div>
                            <span class="font-semibold text-slate-800 text-sm">Kelas {{ $item->nama_kelas }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3 border-b border-slate-50">
                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-medium">
                            {{ $item->tahun_ajaran }}
                        </span>
                    </td>
                    <td class="px-5 py-3 border-b border-slate-50">
                        <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-xs font-medium">
                            <i class="ti ti-users" aria-hidden="true"></i> {{ $item->siswa_count }} siswa
                        </span>
                    </td>
                    @if(Auth::user()->role === 'bendahara')
                    <td class="px-5 py-3 border-b border-slate-50">
                        <div class="flex gap-2">
                            <a href="{{ route('kelas.edit', $item) }}" class="inline-flex items-center gap-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 px-3 py-1.5 rounded-lg text-xs font-medium border border-emerald-200 transition-colors">
                                <i class="ti ti-edit" aria-hidden="true"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('kelas.destroy', $item) }}"
                                  onsubmit="return confirm('Yakin hapus kelas {{ $item->nama_kelas }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 bg-rose-50 hover:bg-rose-100 text-rose-600 px-3 py-1.5 rounded-lg text-xs font-medium border border-rose-200 transition-colors">
                                    <i class="ti ti-trash" aria-hidden="true"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ Auth::user()->role === 'bendahara' ? 5 : 4 }}"
                        class="px-5 py-10 text-center text-sm text-slate-500">
                        Belum ada data kelas. 
                        @if(Auth::user()->role === 'bendahara')
                            <a href="{{ route('kelas.create') }}" class="text-blue-600 hover:underline">Tambah sekarang</a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection