<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Tabungan Siswa</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10pt; color: #000; background: #fff; line-height: 1.4; padding: 30px; }
        
        .kop-surat { text-align: center; border-bottom: 2px solid #000; padding-bottom: 15px; margin-bottom: 20px; }
        .instansi { font-size: 18pt; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
        .alamat { font-size: 10pt; margin-top: 4px; color: #333; }
        .kontak { font-size: 10pt; color: #333; }
        
        .judul-laporan { text-align: center; font-size: 14pt; font-weight: bold; text-transform: uppercase; margin-bottom: 20px; text-decoration: underline; }
        
        .header-table { width: 100%; margin-bottom: 20px; }
        .header-table td { vertical-align: top; }
        
        .meta-info { width: 100%; }
        .meta-info td { font-size: 10pt; padding: 3px 0; }
        .meta-info .label { width: 120px; font-weight: bold; }
        .meta-info .colon { width: 15px; }
        
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 8px; font-size: 9pt; }
        .data-table th { background-color: #f3f3f3; text-align: left; text-transform: uppercase; font-size: 8pt; }
        .data-table tfoot td { font-weight: bold; background-color: #fafafa; }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        .ttd-area { width: 100%; margin-top: 40px; page-break-inside: avoid; }
        .ttd-box { width: 250px; float: right; text-align: center; }
        .ttd-name { margin-top: 60px; font-weight: bold; text-decoration: underline; }
        .clear { clear: both; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <div class="instansi">TK HIDMUT</div>
        <div class="alamat">Jl. Greged No. 123, Kab. Cirebon, Jawa Barat 45151</div>
    </div>

    <div class="judul-laporan">Laporan Tabungan Siswa</div>

    <table class="header-table">
        <tr>
            <td>
                <table class="meta-info">
                    <tr>
                        <td class="label">Dicetak Tanggal</td>
                        <td class="colon">:</td>
                        <td>{{ now()->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Pukul</td>
                        <td class="colon">:</td>
                        <td>{{ now()->translatedFormat('H:i') }} WIB</td>
                    </tr>
                    <tr>
                        <td class="label">Dicetak Oleh</td>
                        <td class="colon">:</td>
                        <td>{{ Auth::user()->name ?? 'Administrator' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div style="font-weight:bold; font-size:10pt; margin-bottom:8px;">Rincian Transaksi:</div>
    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="12%">Tanggal</th>
                <th width="20%">Nama Siswa</th>
                <th width="10%">Kelas</th>
                <th width="10%">Jenis</th>
                <th class="text-right" width="15%">Jumlah</th>
                <th class="text-right" width="15%">Saldo Sesudah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $i => $t)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $t->created_at->translatedFormat('d M Y') }}</td>
                <td>{{ $t->siswa->nama }}</td>
                <td>{{ $t->siswa->kelas->nama_kelas }}</td>
                <td>{{ $t->jenis === 'tabung' ? 'Setor' : 'Tarik' }}</td>
                <td class="text-right">{{ $t->jenis === 'tabung' ? '+' : '-' }}Rp {{ number_format($t->jumlah, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($t->saldo_sesudah, 0, ',', '.') }}</td>
                <td>{{ $t->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center" style="padding:20px;">Tidak ada data transaksi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
        @if($transaksi->count() > 0)
        <tfoot>
            <tr>
                <td colspan="5" class="text-right">Total Setor</td>
                <td class="text-right">+Rp {{ number_format($totalTabung, 0, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="5" class="text-right">Total Tarik</td>
                <td class="text-right">-Rp {{ number_format($totalTarik, 0, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="5" class="text-right" style="font-size: 10pt;">Saldo Akhir (Net)</td>
                <td class="text-right" style="font-size: 10pt;">Rp {{ number_format($totalNet, 0, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="ttd-area">
        <div class="ttd-box" style="float: left;">
            <div>Mengetahui,</div>
            <div style="margin-top: 5px;">Kepala TK / Ketua</div>
            <div class="ttd-name">{{ $ketua->name ?? '.......................' }}</div>
        </div>
        <div class="ttd-box" style="float: right;">
            <div>Cirebon, {{ now()->translatedFormat('d F Y') }}</div>
            <div style="margin-top: 5px;">Bendahara Sekolah</div>
            <div class="ttd-name">{{ $bendahara->name ?? '.......................' }}</div>
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>