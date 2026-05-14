@extends('layouts.app')
@section('title', 'Tambah Transaksi')

@section('content')
<div class="flex items-center gap-3 mb-5 justify-between">
    <div>
        <div class="text-xl font-bold text-gray-900">Tambah Transaksi</div>
        <div class="text-sm text-gray-500 mt-0.5">Catat transaksi setor atau tarik tabungan</div>
    </div>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
    <div class="bg-slate-50 px-6 py-4 border-b border-gray-100">
        <div class="text-base font-bold text-gray-900">Form Tambah Transaksi</div>
        <div class="text-sm text-gray-500 mt-1">Isi data transaksi dengan lengkap dan benar</div>
    </div>
    <div class="p-6">

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 px-4 py-3 rounded-lg text-sm mb-5">
                ✕ {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('transaksi.store') }}">
            @csrf

            {{-- Pilih Siswa --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2" for="siswa_id">Siswa</label>
                <select name="siswa_id" id="siswa_id" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm text-gray-900 outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10 transition-all bg-white" onchange="tampilSaldo(this)" required>
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($siswaList as $s)
                        <option value="{{ $s->id }}"
                            data-saldo="{{ $s->saldo }}"
                            data-nama="{{ $s->nama }}"
                            data-kelas="{{ $s->kelas->nama_kelas }}"
                            {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                            {{ $s->nama }} — {{ $s->kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
                @error('siswa_id')
                    <div class="text-xs text-red-600 mt-1.5">{{ $message }}</div>
                @enderror
            </div>

            {{-- Petugas / Bendahara (Manual Input) --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2" for="nama_petugas">Nama Petugas / Bendahara</label>
                <input type="text" name="nama_petugas" id="nama_petugas" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm text-gray-900 outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10 transition-all bg-white" 
                       value="{{ old('nama_petugas', Auth::user()->name) }}" 
                       placeholder="Masukkan nama Anda..." required>
                @error('nama_petugas')
                    <div class="text-xs text-red-600 mt-1.5">{{ $message }}</div>
                @enderror
                <div class="text-[10px] text-gray-400 mt-1 italic">* Ketikkan nama bendahara yang melakukan input ini</div>
            </div>

            {{-- Info saldo siswa --}}
            <div id="saldo-info" class="bg-slate-50 border border-blue-200 rounded-xl p-4 mb-5 hidden">
                <div class="text-xs text-blue-800 font-semibold" id="saldo-nama"></div>
                <div class="text-sm text-blue-800 mt-0.5">
                    Saldo saat ini: <strong id="saldo-nilai"></strong>
                </div>
            </div>

            {{-- Jenis Transaksi --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Transaksi</label>
                <div class="flex gap-3">
                    <div id="opt-tabung" class="flex-1 p-4 border rounded-xl cursor-pointer text-center transition-all {{ old('jenis', 'tabung') === 'tabung' ? 'border-blue-600 bg-blue-50' : 'border-gray-300 bg-white' }}"
                         onclick="pilihJenis('tabung')">
                        <div class="text-2xl mb-1">↑</div>
                        <div class="text-sm font-semibold text-emerald-800">Setor Tabungan</div>
                        <div class="text-xs text-gray-500 mt-0.5">Menambah saldo</div>
                    </div>
                    <div id="opt-tarik" class="flex-1 p-4 border rounded-xl cursor-pointer text-center transition-all {{ old('jenis') === 'tarik' ? 'border-red-500 bg-red-50' : 'border-gray-300 bg-white' }}"
                         onclick="pilihJenis('tarik')">
                        <div class="text-2xl mb-1">↓</div>
                        <div class="text-sm font-semibold text-rose-800">Tarik Tabungan</div>
                        <div class="text-xs text-gray-500 mt-0.5">Mengurangi saldo</div>
                    </div>
                </div>
                <input type="hidden" name="jenis" id="jenis_input" value="{{ old('jenis', 'tabung') }}">
                @error('jenis')
                    <div class="text-xs text-red-600 mt-1.5">{{ $message }}</div>
                @enderror
            </div>

            {{-- Jumlah --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2" for="jumlah">Jumlah (Rp)</label>
                <input type="number" name="jumlah" id="jumlah" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm text-gray-900 outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10 transition-all bg-white"
                       value="{{ old('jumlah') }}" min="500" step="500"
                       placeholder="Contoh: 50000" required>
                @error('jumlah')
                    <div class="text-xs text-red-600 mt-1.5">{{ $message }}</div>
                @enderror
            </div>

            {{-- Keterangan --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2" for="keterangan">Keterangan (Opsional)</label>
                <textarea name="keterangan" id="keterangan" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm text-gray-900 outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10 transition-all bg-white"
                          rows="3" placeholder="Catatan tambahan...">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <div class="text-xs text-red-600 mt-1.5">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex gap-3 pt-4 border-t border-slate-100 mt-4">
                <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold border-none cursor-pointer transition-colors">
                    <i class="ti ti-check text-sm" aria-hidden="true"></i> Simpan Transaksi
                </button>
                <a href="{{ route('transaksi.index') }}" class="inline-flex items-center gap-2 bg-gray-50 hover:bg-gray-100 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-semibold border border-gray-200 no-underline transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function tampilSaldo(sel) {
    const opt = sel.options[sel.selectedIndex];
    const info = document.getElementById('saldo-info');
    if (opt.value) {
        const saldo = parseFloat(opt.dataset.saldo);
        document.getElementById('saldo-nama').textContent = opt.dataset.nama + ' — ' + opt.dataset.kelas;
        document.getElementById('saldo-nilai').textContent = 'Rp ' + saldo.toLocaleString('id-ID');
        info.classList.remove('hidden');
    } else {
        info.classList.add('hidden');
    }
}

function pilihJenis(jenis) {
    const tabungEl = document.getElementById('opt-tabung');
    const tarikEl = document.getElementById('opt-tarik');
    
    // Reset both
    tabungEl.classList.remove('border-blue-600', 'bg-blue-50');
    tabungEl.classList.add('border-gray-300', 'bg-white');
    
    tarikEl.classList.remove('border-red-500', 'bg-red-50');
    tarikEl.classList.add('border-gray-300', 'bg-white');
    
    // Set selected
    if (jenis === 'tabung') {
        tabungEl.classList.remove('border-gray-300', 'bg-white');
        tabungEl.classList.add('border-blue-600', 'bg-blue-50');
    } else {
        tarikEl.classList.remove('border-gray-300', 'bg-white');
        tarikEl.classList.add('border-red-500', 'bg-red-50');
    }
    
    document.getElementById('jenis_input').value = jenis;
}

// Jalankan saat load jika ada old value
document.addEventListener('DOMContentLoaded', function () {
    const sel = document.getElementById('siswa_id');
    if (sel.value) tampilSaldo(sel);
});
</script>
@endpush
@endsection