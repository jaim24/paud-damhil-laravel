<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pernyataan - {{ $applicant->child_name }}</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            line-height: 1.6;
            margin: 0;
            padding: 2cm;
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 2rem;
            border-bottom: 3px double #000;
            padding-bottom: 1rem;
        }
        .header h1 {
            margin: 0;
            font-size: 18pt;
            text-transform: uppercase;
        }
        .header p {
            margin: 0;
            font-size: 12pt;
        }
        .content {
            margin-bottom: 2rem;
        }
        .title {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 2rem;
            font-size: 14pt;
        }
        .form-group {
            margin-bottom: 0.5rem;
        }
        .label {
            display: inline-block;
            width: 200px;
        }
        .signature-section {
            margin-top: 3rem;
            display: flex;
            justify-content: flex-end;
        }
        .signature-box {
            text-align: center;
            width: 250px;
        }
        .signature-space {
            height: 80px;
        }
        .materai-box {
            border: 1px dashed #ccc;
            width: 80px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            color: #999;
            font-size: 10px;
            margin-bottom: 10px;
        }
        @media print {
            body { 
                padding: 0; 
                margin: 2cm;
            }
            .no-print {
                display: none;
            }
        }
        .btn-print {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background: #4f46e5;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: sans-serif;
            text-decoration: none;
        }
    </style>
</head>
<body onload="window.print()">

    <a href="javascript:window.print()" class="btn-print no-print">🖨️ Cetak Surat</a>

    <div class="header">
        <h1>PAUD DAMHIL GORONTALO</h1>
        <p>{{ $setting->school_address ?? 'Alamat Sekolah' }}</p>
        <p>Telp: {{ $setting->school_phone ?? '-' }} | Email: {{ $setting->school_email ?? '-' }}</p>
    </div>

    <div class="content">
        <div class="title">SURAT PERNYATAAN ORANG TUA/WALI</div>

        <p>Saya yang bertanda tangan di bawah ini:</p>

        <div class="form-group">
            <span class="label">Nama Orang Tua/Wali</span>: {{ $applicant->father_name }} / {{ $applicant->mother_name }}
        </div>
        <div class="form-group">
            <span class="label">Alamat</span>: {{ $applicant->address_street }}
        </div>
        <div class="form-group">
            <span class="label">No. HP/WA</span>: {{ $applicant->phone }}
        </div>

        <p>Adalah orang tua/wali dari calon siswa:</p>

        <div class="form-group">
            <span class="label">Nama Anak</span>: <strong>{{ $applicant->child_name }}</strong>
        </div>
        <div class="form-group">
            <span class="label">Tempat, Tanggal Lahir</span>: {{ $applicant->birth_place }}, {{ \Carbon\Carbon::parse($applicant->birth_date)->isoFormat('D MMMM Y') }}
        </div>
        <div class="form-group">
            <span class="label">Jenis Kelamin</span>: {{ $applicant->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
        </div>

        <p>Dengan ini menyatakan dengan sesungguhnya bahwa:</p>
        <ol>
            <li>Kami menyerahkan anak kami sepenuhnya kepada Pihak Sekolah untuk dididik, dibimbing, dan dilatih sesuai dengan program sekolah.</li>
            <li>Kami bersedia bekerja sama dengan pihak sekolah dalam hal pembinaan dan pengawasan anak kami.</li>
            <li>Kami bersedia mematuhi segala peraturan dan tata tertib yang berlaku di PAUD Damhil Gorontalo.</li>
            <li>Kami bersedia memenuhi kewajiban administrasi sekolah tepat waktu.</li>
            <li>Apabila di kemudian hari kami melanggar pernyataan ini, kami bersedia menerima sanksi yang ditetapkan oleh sekolah.</li>
        </ol>
        
        <p>Demikian surat pernyataan ini kami buat dengan sadar dan tanpa paksaan dari pihak manapun untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <p>Gorontalo, {{ now()->isoFormat('D MMMM Y') }}</p>
            <p>Yang Membuat Pernyataan,</p>
            <br>
            <div class="materai-box">Materai 10.000</div>
            <div class="signature-space"></div>
            <p><strong>( {{ $applicant->father_name }} / {{ $applicant->mother_name }} )</strong></p>
            <p style="font-size: 10pt;">Nama & Tanda Tangan Orang Tua</p>
        </div>
    </div>

</body>
</html>
