<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Tabungan Siswa</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #000; background: #fff; line-height: 1.4; }
        .container { width: 100%; padding: 24px; }

        .header { padding-bottom: 10px; margin-bottom: 16px; border-bottom: 1px solid #000; }
        .header-title { font-size: 16px; font-weight: 700; }
        .header-sub { font-size: 12px; margin-top: 4px; }
        .header-meta { font-size: 10px; margin-top: 6px; color: #333; }

        .stat-row { display: flex; gap: 8px; margin: 16px 0; }
        .stat-box { flex: 1; border: 1px solid #000; padding: 8px 10px; }
        .stat-label { font-size: 9px; font-weight: 700; text-transform: uppercase; }
        .stat-value { font-size: 12px; margin-top: 4px; }

        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #000; padding: 8px 10px; text-align: left; font-size: 11px; }
        thead { background: #f3f3f3; }
        tfoot td { font-weight: 700; }

        .footer { margin-top: 16px; padding-top: 10px; border-top: 1px solid #000; font-size: 10px; color: #333; display: flex; justify-content: space-between; }
    </style>
</head>
<body>

    <div class="header">
        <div class="header-title">Laporan Tabungan Siswa TK</div>
        <div class="header-sub">Sistem Informasi Tabungan Siswa</div>
        <div class="header-meta">Dicetak: {{ now()->format('d F Y, H:i') }} WIB</div>
    </div>

    {{-- Ringkasan --}}
    <table style="margin-bottom:16px;">
        <tr>
            <td style="border:none;padding:0;width:33%;">
                <div class="stat-box" style="margin-right:6px;">
                    <div class="stat-label">Total Transaksi</div>
                    <div class="stat-value" style="color:#1e293b;">{{ $transaksi->count() }}</div>
                </div>
            </td>
            <td style="border:none;padding:0;width:33%;">
                <div class="stat-box" style="margin:0 3px;">
                    <div class="stat-label">Total Setor</div>
                    <div class="stat-value" style="color:#065f46;">Rp {{ number_format($totalTabung, 0, ',', '.') }}</div>
                </div>
            </td>
            <td style="border:none;padding:0;width:33%;">
                <div class="stat-box" style="margin-left:6px;">
                    <div class="stat-label">Total Tarik</div>
                    <div class="stat-value" style="color:#9f1239;">Rp {{ number_format($totalTarik, 0, ',', '.') }}</div>
                </div>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Saldo Sebelum</th>
                <th>Saldo Sesudah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $i => $t)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $t->created_at->format('d/m/Y') }}</td>
                <td>{{ $t->siswa->nama }}</td>
                <td>{{ $t->siswa->kelas->nama_kelas }}</td>
                <td>
                    {{ $t->jenis === 'tabung' ? 'Setor' : 'Tarik' }}
                </td>
                <td>
                    {{ $t->jenis === 'tabung' ? '+' : '-' }}Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                </td>
                <td>Rp {{ number_format($t->saldo_sebelum, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($t->saldo_sesudah, 0, ',', '.') }}</td>
                <td>{{ $t->keterangan ?? '—' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align:center;padding:20px;color:#94a3b8;">Tidak ada data.</td>
            </tr>
            @endforelse
        </tbody>
        @if($transaksi->count() > 0)
        <tfoot>
            <tr>
                <td colspan="5" style="text-align:right;">TOTAL</td>
                <td>+Rp {{ number_format($totalTabung, 0, ',', '.') }} / -Rp {{ number_format($totalTarik, 0, ',', '.') }}</td>
                <td></td>
                <td>Net: Rp {{ number_format($totalNet, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="footer">
        <span>Sistem Informasi Tabungan Siswa TK</span>
        <span>Dicetak oleh sistem pada {{ now()->format('d F Y') }}</span>
    </div>

</body>
</html>