@extends('layouts.app')
@section('title', 'Riwayat Transaksi Dihapus')

@section('content')

<div class="flex justify-between items-center mb-5">
    <div>
        <div class="text-xl font-semibold text-slate-800">Riwayat Transaksi Dihapus</div>
        <div class="text-sm text-slate-500 mt-0.5">Daftar transaksi yang telah dibatalkan/dihapus beserta alasannya</div>
    </div>
    <a href="{{ route('transaksi.index') }}" class="inline-flex items-center gap-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors">
        <i class="ti ti-arrow-left" aria-hidden="true"></i> Kembali
    </a>
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
    <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
        <div class="text-sm font-semibold text-slate-800">Transaksi Terhapus (Audit Trail)</div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Tanggal Transaksi</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Siswa</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Jenis</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Jumlah</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Dihapus Pada</th>
                    <th class="px-5 py-3 text-left text-xs text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">Alasan Hapus</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksi as $t)
                <tr class="hover:bg-slate-50/50 transition-colors opacity-75">
                    <td class="px-5 py-3 text-xs text-slate-500 border-b border-slate-50">
                        {{ $t->created_at->translatedFormat('d M Y') }}<br>
                        <span class="text-slate-400">{{ $t->created_at->format('H:i') }}</span>
                    </td>
                    <td class="px-5 py-3 border-b border-slate-50">
                        <div class="font-semibold text-slate-800 text-sm">{{ $t->siswa->nama }}</div>
                        <div class="text-xs text-slate-500">{{ $t->siswa->kelas->nama_kelas }}</div>
                    </td>
                    <td class="px-5 py-3 text-sm border-b border-slate-50">
                        <span class="text-slate-400 font-medium">{{ $t->jenis === 'tabung' ? 'Setor' : 'Tarik' }}</span>
                    </td>
                    <td class="px-5 py-3 text-sm border-b border-slate-50">
                        <span class="text-slate-400 font-medium italic line-through">
                            Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-xs text-rose-600 border-b border-slate-50 font-medium">
                        {{ $t->deleted_at->translatedFormat('d M Y, H:i') }}
                    </td>
                    <td class="px-5 py-3 text-sm border-b border-slate-50">
                        <div class="bg-rose-50 text-rose-800 p-2 rounded border border-rose-100 text-xs italic">
                            "{{ $t->alasan_hapus }}"
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-10 text-center text-sm text-slate-500">
                        Tidak ada riwayat transaksi yang dihapus.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($transaksi->hasPages())
    <div class="px-5 py-4 border-t border-slate-100 flex justify-end">
        {{ $transaksi->links() }}
    </div>
    @endif
</div>
@endsection
