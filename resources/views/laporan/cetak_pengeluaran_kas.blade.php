<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengeluaran Kas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-header h1 {
            margin: 0;
        }
        .invoice-details {
            margin-bottom: 20px;
            text-align: left;
        }
        .invoice-footer {
            width: 100%;
        }
        .invoice-footer td {
            padding: 5px;
            text-align: right;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table td, table th {
            border: 1px solid #000000;
            padding: 8px;
        }
        table tr:nth-child(even){background-color: #ffffff;}
        table tr:hover {background-color: #ffffff;}
        table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #ffffff;
            color: rgb(0, 0, 0);
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h1>Laporan Pengeluaran Kas</h1>
    </div>
    <div class="invoice-details">
        <p>Periode: {{ $periode }}</p>
    </div>
    <div class="content">
    <table>
        <tr>
            <th>#</th>
            <th>Tanggal</th>
            <th>ID </th>
            <th>Total</th>
        </tr>
        @foreach ($pengeluaran_kas as $pengeluaran)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $pengeluaran->tanggal_transaksi }}</td>
            <td>{{ $pengeluaran->keterangan }}</td>
            <td>{{ number_format($pengeluaran->jumlah, 0, '.', '.') }}</td>
        </tr>
        @endforeach
    </table>
    </div>
    <div class="invoice-footer">
        <table>
            <tr>
                <td>Total Pengeluaran Kas</td>
                <td>{{ number_format($total_pengeluaran, 0, '.', '.') }}</td>
            </tr>
        </table>
</body>
</html>