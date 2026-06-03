<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #2D2A26; font-size: 12px; }
        .header { border-bottom: 1px solid #E6E4DD; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { font-size: 18px; margin: 0; }
        .header p { margin: 4px 0 0 0; color: #73706A; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #E6E4DD; padding: 8px; text-align: left; }
        th { background-color: #FAF9F6; font-weight: bold; color: #5C5954; font-size: 11px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-green { color: #2E5C3A; font-weight: bold; }
        .text-red { color: #B3412F; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Keluar Masuk Persediaan</h1>
        <p>Apotek Mitra Sehat</p>
        <p>Periode: {{ $dari ? \Carbon\Carbon::parse($dari)->format('d/m/Y') : 'Awal' }} — {{ $sampai ? \Carbon\Carbon::parse($sampai)->format('d/m/Y') : 'Akhir' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%">Tanggal</th>
                <th width="20%">Nama Obat</th>
                <th width="15%">Kategori</th>
                <th width="10%" class="text-center">Tipe</th>
                <th width="10%" class="text-right">Jumlah</th>
                <th width="25%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $i => $item)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item['tanggal'])->format('d/m/Y') }}</td>
                <td>{{ $item['nama_obat'] }}</td>
                <td>{{ $item['kategori'] }}</td>
                <td class="text-center" style="text-transform: capitalize;">{{ $item['tipe'] }}</td>
                <td class="text-right {{ $item['tipe'] === 'masuk' ? 'text-green' : 'text-red' }}">
                    {{ $item['tipe'] === 'masuk' ? '+' : '-' }}{{ $item['jumlah'] }}
                </td>
                <td>{{ $item['keterangan'] }}</td>
            </tr>
            @endforeach
        </tbody>
        @if($laporan->isNotEmpty())
        <tfoot>
            <tr>
                <td colspan="5" class="text-right"><strong>TOTAL AKUMULASI:</strong></td>
                <td colspan="2" class="text-center">
                    <span class="text-green">+{{ $totalMasuk }}</span> / 
                    <span class="text-red">-{{ $totalKeluar }}</span>
                </td>
            </tr>
        </tfoot>
        @endif
    </table>

</body>
</html>