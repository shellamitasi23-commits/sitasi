@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <h1 class="text-3xl font-semibold text-slate-800 mb-5">Dashboard SITASI</h1>

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
            <div class="text-xs font-medium text-slate-500 mb-1.5 uppercase tracking-wider">Total Siswa</div>
            <div class="text-3xl font-bold text-slate-800">{{ $totalSiswa }}</div>
            <div class="text-xs text-slate-400 mt-1">Semua kelas</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
            <div class="text-xs font-medium text-slate-500 mb-1.5 uppercase tracking-wider">Total Tabungan</div>
            <div class="text-3xl font-bold text-emerald-600">Rp {{ number_format($totalTabungan, 0, ',', '.') }}</div>
            <div class="text-xs text-slate-400 mt-1">Akumulasi semua siswa</div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
            <div class="text-xs font-medium text-slate-500 mb-1.5 uppercase tracking-wider">Transaksi Hari Ini</div>
            <div class="text-3xl font-bold text-blue-600">{{ $transaksiHariIni }}</div>
            <div class="text-xs text-slate-400 mt-1">{{ now()->translatedFormat('d F Y') }}</div>
        </div>

    </div>

    {{-- Grafik --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Bar Chart: Transaksi 7 Hari --}}
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm lg:col-span-2">
            <div class="text-sm font-semibold text-slate-800 mb-4">Transaksi 7 Hari Terakhir</div>
            <canvas id="chartTransaksi" height="120"></canvas>
        </div>

        {{-- Bar Chart: Tabungan Per Kelas --}}
        <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm lg:col-span-1">
            <div class="text-sm font-semibold text-slate-800 mb-4">Tabungan Per Kelas</div>
            <canvas id="chartKelas" height="120"></canvas>
        </div>

    </div>

@endsection

@push('scripts')
<script>
    const transaksiData = @json($grafikTransaksi);
    const kelasData     = @json($grafikKelas);

    new Chart(document.getElementById('chartTransaksi'), {
        type: 'bar',
        data: {
            labels: transaksiData.map(d => d.tanggal),
            datasets: [
                {
                    label: 'Tabung',
                    data: transaksiData.map(d => d.total_tabung),
                    backgroundColor: '#3b82f6',
                    borderRadius: 4,
                },
                {
                    label: 'Tarik',
                    data: transaksiData.map(d => d.total_tarik),
                    backgroundColor: '#fca5a5',
                    borderRadius: 4,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top', labels: { font: { size: 11 } } }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: { size: 11 },
                        callback: val => 'Rp ' + val.toLocaleString('id-ID')
                    }
                },
                x: { ticks: { font: { size: 11 } } }
            }
        }
    });

    new Chart(document.getElementById('chartKelas'), {
        type: 'bar',
        data: {
            labels: kelasData.map(d => d.nama),
            datasets: [{
                label: 'Total Tabungan',
                data: kelasData.map(d => d.total),
                backgroundColor: ['#3b82f6','#60a5fa','#93c5fd','#bfdbfe'],
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: { size: 11 },
                        callback: val => 'Rp ' + val.toLocaleString('id-ID')
                    }
                },
                x: { ticks: { font: { size: 11 } } }
            }
        }
    });
</script>
@endpush