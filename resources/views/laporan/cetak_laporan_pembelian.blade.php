<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pembelian</title>
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
        <h1>Laporan Penjualan</h1>
    </div>
    <div class="invoice-details">
        <p>Periode: {{ $periode }}</p>
    </div>
    <table>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>ID Beli</th>
            <th>Supplier</th>
            <th>Total</th>
        </tr>
        @foreach ($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->tanggal_beli }}</td>
            <td>{{ $item->id_beli }}</td>
            <td>{{ $item->supplier->nama_supplier }}</td>
            <td>{{ $item->total_beli }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>