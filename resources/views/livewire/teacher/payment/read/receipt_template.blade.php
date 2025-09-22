<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 20px;
            color: #333;
        }

        /* .header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .logo {
            width: 30%;
        }

        .invoice-title {
            text-align: right;
        } */

        .invoice-title h2 {
            margin: 0;
            font-size: 18px;
        }

        .details,
        .summary {
            margin-top: 20px;
        }

        .details table,
        .summary table {
            width: 100%;
        }

        .details td,
        .summary td {
            padding: 4px 0;
        }

        .bill-section {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        /* .bill-to,
        .bill-from {
            width: 48%;
        } */

        .description-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .description-table th,
        .description-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .description-table th {
            background-color: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 30px;
            font-style: italic;
            text-align: center;
        }
    </style>
</head>

<body>
    <table class="header-table" style="width: 100%; border-collapse: collapse; margin-bottom: 80px;">
        <tr>
            <td style="width: 50%;">
                <img src="{{ public_path('img/logo-mipa.png') }}" alt="Logo" width="70">
            </td>
            <td style="text-align: right;">
                <h2>Kuitansi Pembayaran</h2>
                <div>No: {{ $dataReceipt['receipt_number'] }}</div>
                <div>Tanggal: {{ $dataReceipt['receipt_date'] }}</div>
            </td>
        </tr>
    </table>

    {{-- <div class="header">
        <div class="logo">
            <img src="{{ public_path('images/logo.png') }}" alt="Logo" width="70">
        </div>
        <div class="invoice-title">
            <h2>Kwitansi Pembayaran</h2>
            <div>No: {{ $dataReceipt['receipt_number'] }}</div>
            <div>Tanggal: {{ $dataReceipt['receipt_date'] }}</div>
        </div>
    </div> --}}

    {{-- <div class="bill-section">
        <div class="bill-to">
            <strong>Kepada:</strong><br>
            {{ $dataReceipt['name'] }}<br>
            Kelas: {{ $dataReceipt['grade_name'] }}<br>
            Group: {{ $dataReceipt['group_name'] }}
        </div>
        <div class="bill-from">
            <strong>Diterbitkan oleh:</strong><br>
            Mi Pancasila Mojosari Mojokerto<br>
            Jl. S. Parman No.1, RT.3/RW.6<br>
            Mojosari, Mojokerto, Jawa Timur 61382
        </div>
    </div> --}}

    <table class="header-table" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <tr>
            <td style="width: 50%;">
                <div class="bill-to">
                    <strong>Kepada:</strong><br>
                    {{ $dataReceipt['name'] }}<br>
                    Kelas: {{ $dataReceipt['grade_name'] }}<br>
                    Group: {{ $dataReceipt['group_name'] }}
                </div>
            </td>
            <td style="text-align: right;">
                <div class="bill-from">
                    <strong>Diterbitkan oleh:</strong><br>
                    Mi Pancasila Mojosari Mojokerto<br>
                    Jl. S. Parman No.1, RT.3/RW.6<br>
                    Mojosari, Mojokerto, Jawa Timur 61382
                </div>
            </td>
        </tr>
    </table>

    <table class="description-table">
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th class="text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $dataReceipt['payment_type'] }}</td>
                <td class="text-right">Rp{{ number_format($dataReceipt['amount'], 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="summary">
        <table>
            <tr>
                <td class="text-right"><strong>Total Dibayar:</strong></td>
                <td class="text-right"><strong>Rp{{ number_format($dataReceipt['amount'], 0, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Terima kasih atas pembayaran Anda. <br>
        Petugas: {{ $dataReceipt['teacher_name'] }}
    </div>

</body>

</html>
