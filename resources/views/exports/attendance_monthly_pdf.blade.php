<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Rekap Absensi - {{ $monthName }} {{ $year }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }
        .container {
            padding: 20px;
        }
        /* Header / Kop Surat */
        .header {
            text-align: center;
            border-bottom: 3px double #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 16px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .header p {
            font-size: 10px;
            color: #666;
        }
        /* Title */
        .title {
            text-align: center;
            margin-bottom: 20px;
        }
        .title h2 {
            font-size: 14px;
            text-decoration: underline;
            margin-bottom: 5px;
        }
        .title p {
            font-size: 11px;
            color: #666;
        }
        /* Info Box */
        .info-box {
            background: #f0f9ff;
            border: 1px solid #0ea5e9;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 10px;
        }
        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: center;
        }
        th {
            background: #0ea5e9;
            color: white;
            font-weight: bold;
            font-size: 10px;
        }
        td {
            font-size: 10px;
        }
        td.left {
            text-align: left;
        }
        tr:nth-child(even) {
            background: #f8fafc;
        }
        .hadir { color: #16a34a; font-weight: bold; }
        .terlambat { color: #d97706; font-weight: bold; }
        .izin { color: #2563eb; font-weight: bold; }
        .sakit { color: #9333ea; font-weight: bold; }
        .alpha { color: #dc2626; font-weight: bold; }
        /* Signature */
        .signature {
            margin-top: 40px;
            width: 100%;
        }
        .signature-box {
            float: right;
            width: 200px;
            text-align: center;
        }
        .signature-space {
            height: 60px;
        }
        .signature-line {
            border-top: 1px solid #333;
            padding-top: 5px;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        /* Footer */
        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header / Kop Surat -->
        <div class="header">
            <h1>{{ $settings->school_name ?? 'PAUD Pintar' }}</h1>
            <p>{{ $settings->contact_address ?? 'Alamat Sekolah' }}</p>
            <p>Telp: {{ $settings->contact_phone ?? '-' }} | Email: {{ $settings->email ?? '-' }}</p>
        </div>

        <!-- Title -->
        <div class="title">
            <h2>REKAP ABSENSI GURU</h2>
            <p>Periode: {{ $monthName }} {{ $year }}</p>
        </div>

        <!-- Info Box -->
        <div class="info-box">
            <strong>Hari Kerja:</strong> {{ $workingDays }} hari &nbsp; | &nbsp;
            <strong>Total Guru:</strong> {{ count($teachers) }} orang &nbsp; | &nbsp;
            <strong>Tanggal Cetak:</strong> {{ now()->isoFormat('D MMMM Y, HH:mm') }}
        </div>

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th style="width: 150px;">Nama Guru</th>
                    <th style="width: 80px;">NIP</th>
                    <th style="width: 100px;">Jabatan</th>
                    <th style="width: 50px;">Hadir</th>
                    <th style="width: 50px;">Terlambat</th>
                    <th style="width: 40px;">Izin</th>
                    <th style="width: 40px;">Sakit</th>
                    <th style="width: 40px;">Alpha</th>
                    <th style="width: 50px;">%</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teachers as $index => $teacher)
                @php
                    $hadir = $teacher->attendances->where('status', 'hadir')->count();
                    $terlambat = $teacher->attendances->where('status', 'terlambat')->count();
                    $izin = $teacher->attendances->where('status', 'izin')->count();
                    $sakit = $teacher->attendances->where('status', 'sakit')->count();
                    $alpha = max(0, $workingDays - ($hadir + $terlambat + $izin + $sakit));
                    $percentage = $workingDays > 0 ? round((($hadir + $terlambat) / $workingDays) * 100) : 0;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="left">{{ $teacher->name }}</td>
                    <td>{{ $teacher->nip ?? '-' }}</td>
                    <td class="left">{{ $teacher->position ?? '-' }}</td>
                    <td class="hadir">{{ $hadir }}</td>
                    <td class="terlambat">{{ $terlambat }}</td>
                    <td class="izin">{{ $izin }}</td>
                    <td class="sakit">{{ $sakit }}</td>
                    <td class="alpha">{{ $alpha }}</td>
                    <td>{{ $percentage }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Signature -->
        <div class="signature clearfix">
            <div class="signature-box">
                <p>{{ $settings->contact_address ? explode(',', $settings->contact_address)[0] : 'Kota' }}, {{ now()->isoFormat('D MMMM Y') }}</p>
                <p>Kepala Sekolah,</p>
                <div class="signature-space"></div>
                <div class="signature-line">
                    <strong>________________________</strong><br>
                    <span style="font-size: 9px;">NIP. ________________</span>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        Dokumen ini dicetak secara otomatis oleh Sistem Informasi {{ $settings->school_name ?? 'PAUD Pintar' }}
    </div>
</body>
</html>
