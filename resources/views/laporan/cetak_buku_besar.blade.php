<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Buku Besar</title>
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
        <h1>Laporan Buku Besar</h1>
    </div>
    <div class="invoice-details">
        <p>Periode: {{ $periode }}</p>
    </div>
    @php
    $b = 1;
    $saldo = 0;
    @endphp
    <div class="content">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($kasEntries as $kas)
                <tr>
                    <td>{{ $b++ }}</td>
                    <td>{{ date('d-m-Y', strtotime($kas->tanggal)) }}</td>
                    <td>{{ $kas->keterangan }}</td>
                    <td>{{ $kas->debit == 0 ? '-' : number_format($kas->debit, 0, '.', '.')  }}</td>
                    <td>{{ $kas->kredit == 0 ? '-' : number_format($kas->kredit, 0, '.', '.')  }}</td>
                    <td>{{ number_format($kas->saldo, 0, '.', '.') }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr class="font-weight-bold">
                    <td colspan="5" align="right"><h4>Total</h4></td>
                    <td><h4>{{ number_format($kasEntries->last()->saldo, 0, '.', '.') }}</h4></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>