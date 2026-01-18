<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pernyataan - {{ $applicant->child_name ?? 'Pendaftar' }}</title>
    <style>
        @page {
            size: A4;
            margin: 2cm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #000;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 16pt;
            font-weight: bold;
            text-decoration: underline;
            margin: 0;
        }
        .content {
            text-align: justify;
        }
        .field {
            display: flex;
            margin-bottom: 5px;
        }
        .field-label {
            width: 150px;
            flex-shrink: 0;
        }
        .field-value {
            flex: 1;
            border-bottom: 1px dotted #000;
            padding-left: 5px;
        }
        .signature-area {
            margin-top: 50px;
            display: flex;
            justify-content: flex-end;
        }
        .signature-box {
            text-align: center;
            width: 250px;
        }
        .signature-space {
            height: 80px;
            border: 2px solid #000;
            margin: 15px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10pt;
            color: #666;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 10px;
            padding-top: 5px;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
        }
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #0ea5e9;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
        }
        .print-button:hover {
            background: #0284c7;
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">🖨️ Cetak Surat</button>

    <div class="header">
        <h1>SURAT PERNYATAAN</h1>
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini:</p>

        <div class="field">
            <span class="field-label">Nama</span>
            <span>:</span>
            <span class="field-value">{{ $applicant->father_name ?? '.......................................................' }}</span>
        </div>
        <div class="field">
            <span class="field-label">Alamat</span>
            <span>:</span>
            <span class="field-value">{{ $applicant->full_address ?? '.......................................................' }}</span>
        </div>
        <div class="field">
            <span class="field-label">No. Telepon</span>
            <span>:</span>
            <span class="field-value">{{ $applicant->phone ?? '.......................................................' }}</span>
        </div>
        <div class="field">
            <span class="field-label">Pekerjaan</span>
            <span>:</span>
            <span class="field-value">{{ $applicant->father_job ?? '.......................................................' }}</span>
        </div>

        <p style="margin-top: 20px;">Telah mengisi Formulir Pendaftaran Anak Didik Baru, untuk mendaftarkan anak kami:</p>

        <div class="field">
            <span class="field-label">Nama</span>
            <span>:</span>
            <span class="field-value">{{ $applicant->child_name ?? '.......................................................' }}</span>
        </div>
        <div class="field">
            <span class="field-label">Tempat/Tgl. Lahir</span>
            <span>:</span>
            <span class="field-value">
                @if($applicant->birth_place && $applicant->birth_date)
                    {{ $applicant->birth_place }}, {{ $applicant->birth_date->format('d F Y') }}
                @else
                    .......................................................
                @endif
            </span>
        </div>

        <p style="margin-top: 20px;">
            Sebagai anak didik baru di <strong>TK/KB Damhil DWP Universitas Negeri Gorontalo</strong> 
            Tahun Ajaran <strong>{{ $academicYear ?? date('Y') . '/' . (date('Y') + 1) }}</strong> 
            dan bersedia memenuhi semua persyaratan/tata tertib (aturan) yang telah ditentukan oleh Sekolah.
        </p>

        <p>
            Demikian surat pernyataan ini saya buat dengan harapan agar anak saya 
            dapat diterima di TK/KB Damhil DWP Universitas Negeri Gorontalo.
        </p>

        <div class="signature-area">
            <div class="signature-box">
                <p>Gorontalo, {{ now()->format('d F Y') }}</p>
                <p>Yang membuat pernyataan,</p>
                
                <div class="signature-space">
                    Materai<br>Rp 10.000
                </div>

                <div class="signature-line">
                    ( ________________________________ )
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto focus for printing
        window.onload = function() {
            // Show print dialog after 500ms
            // setTimeout(function() { window.print(); }, 500);
        }
    </script>
</body>
</html>
