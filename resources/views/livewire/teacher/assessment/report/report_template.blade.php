<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Pembayaran | Rekapitulasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 10px;
        }

        .header {
            text-align: center;
            padding: 20px;
        }

        .header h1 {
            font-weight: bold;
            font-size: 24px;
            margin: 10px 0;
        }

        .info {
            margin-bottom: 30px;
        }

        .info .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 14px;
        }

        .info .row span {
            text-align: left;
            white-space: nowrap;
        }

        .table-container {
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        thead {
            background-color: #708871;
            color: white;
        }

        th {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th.nisn-column {
            width: 30%;
        }


        th.score-column {
            width: 5%;
        }

        tbody tr {
            background-color: #f9f9f9;
            border: 1px solid #ccc;
        }

        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>REKAPITULASI NILAI SISWA</h1>
        <h1>MI PANCASILA MOJOSARI MOJOKERTO</h1>
    </div>

    <div class="info">
        <div class="row">
            <span style="width:30%;">Rombel</span>
            <span style="width: 1%; text-align: center;">:</span>
            <span style="width: 69%;">{{ $group->name }}</span>
        </div>
        <div class="row">
            <span style="width:30%;">Tipe Penilaian</span>
            <span style="width: 1%; text-align: center;">:</span>
            <span style="width: 69%;">{{ $assessmentType->name }}</span>
        </div>
        <div class="row">
            <span style="width:30%;">Kode Penilaian</span>
            <span style="width: 1%; text-align: center;">:</span>
            <span style="width: 69%;">{{ $assessmentType->code }}</span>
        </div>
        <div class="row">
            <span style="width:30%;">Mata Pelajaran</span>
            <span style="width: 1%; text-align: center;">:</span>
            <span style="width: 69%;">{{ $subject->name }} : {{ $subject->code }}</span>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th class="name-column">Nama</th>
                    <th class="nisn-column">Nisn</th>
                    <th class="score-column">Nilai</th>


                </tr>
            </thead>
            <tbody>
                @foreach ($studentScores as $sc)
                    <tr>
                        <td>{{ $sc['student_name'] }}</td>
                        <td>{{ $sc['student_nisn'] }}</td>
                        <td>{{ $sc['score'] }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>

</div>


</body>

</html>
