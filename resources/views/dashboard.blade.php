@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <h1 style="font-size:18px; font-weight:500; color:#1e293b; margin-bottom:20px;">Dashboard</h1>

    {{-- Stat Cards --}}
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-bottom:24px;">
        
        <div style="background:#fff; border:0.5px solid #e2e8f0; border-radius:10px; padding:16px;">
            <div style="font-size:12px; color:#64748b; margin-bottom:6px;">Total Siswa</div>
            <div style="font-size:24px; font-weight:500; color:#1e293b;">{{ $totalSiswa }}</div>
            <div style="font-size:11px; color:#94a3b8; margin-top:2px;">Semua kelas</div>
        </div>

        <div style="background:#fff; border:0.5px solid #e2e8f0; border-radius:10px; padding:16px;">
            <div style="font-size:12px; color:#64748b; margin-bottom:6px;">Total Tabungan</div>
            <div style="font-size:24px; font-weight:500; color:#1e293b;">Rp {{ number_format($totalTabungan, 0, ',', '.') }}</div>
            <div style="font-size:11px; color:#94a3b8; margin-top:2px;">Akumulasi semua siswa</div>
        </div>

        <div style="background:#fff; border:0.5px solid #e2e8f0; border-radius:10px; padding:16px;">
            <div style="font-size:12px; color:#64748b; margin-bottom:6px;">Transaksi Hari Ini</div>
            <div style="font-size:24px; font-weight:500; color:#1e293b;">{{ $transaksiHariIni }}</div>
            <div style="font-size:11px; color:#94a3b8; margin-top:2px;">{{ now()->translatedFormat('d F Y') }}</div>
        </div>

    </div>

    {{-- Grafik --}}
    <div style="display:grid; grid-template-columns:2fr 1fr; gap:16px;">

        {{-- Bar Chart: Transaksi 7 Hari --}}
        <div style="background:#fff; border:0.5px solid #e2e8f0; border-radius:10px; padding:16px;">
            <div style="font-size:13px; font-weight:500; color:#1e293b; margin-bottom:16px;">Transaksi 7 Hari Terakhir</div>
            <canvas id="chartTransaksi" height="120"></canvas>
        </div>

        {{-- Bar Chart: Tabungan Per Kelas --}}
        <div style="background:#fff; border:0.5px solid #e2e8f0; border-radius:10px; padding:16px;">
            <div style="font-size:13px; font-weight:500; color:#1e293b; margin-bottom:16px;">Tabungan Per Kelas</div>
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