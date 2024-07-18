<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faktur Pembelian</title>
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
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            text-align: left;
            padding: 8px;
            border-top: 1px solid rgb(165, 165, 165);
            border-bottom: 1px solid rgb(165, 165, 165);
        }
        .total {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h1>Faktur Pembelian</h1>
    </div>
    <div class="invoice-details">
        <p>ID Beli : {{ $pembelian->id_beli }}</p>
        <p>Tanggal &nbsp; &nbsp;: {{ $pembelian->tanggal_beli }}</p>
        <p>Supplier : {{ $pembelian->supplier->nama_supplier }}</p>
    </div>
    <div class="content">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($detail_belis as $index => $detail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $detail->kd_barang }}</td>
                    <td>{{ $detail->barang->nama_barang }}</td>
                    <td>{{ number_format($detail->harga, 0, ',', '.') }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="invoice-footer">
        <table>
            <tr>
                <td>Total Harga &nbsp; &nbsp; {{ number_format($detail_belis->sum('subtotal'), 0, ',', '.') }}</td>
                <td></td>
            </tr>
            <tr>    
                <td>Total Bayar &nbsp; &nbsp; {{ number_format($pembelian->total_beli, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Diterima &nbsp; &nbsp;    {{ number_format($pembelian->bayar, 0, ',', '.') }}</td>
            <tr>
                <td>Kembali &nbsp; &nbsp;    {{ number_format($pembelian->kembali, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
</body>
</html>