@extends('layouts.app')

@section('title', 'Cek SPP')

@section('content')
<div class="container mt-2">
    <div class="form-card">
        <h2 class="text-center mb-1">Cek Tagihan SPP</h2>
        <form action="{{ route('check.spp_process') }}" method="POST">
            @csrf
            <input type="text" name="nisn" class="form-control mb-1" required placeholder="Masukkan ID (Contoh: 12345)">
            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">
                <i class="ph ph-magnifying-glass"></i> Cek Tagihan
            </button>
        </form>

        @if(isset($invoice))
            <div class="alert alert-error mt-2">
                <h4>Tagihan Ditemukan!</h4>
                <p>Siswa: <strong>{{ $invoice->student_name }}</strong></p>
                <p>Bulan: {{ $invoice->month }}</p>
                <h3 style="color:var(--primary)">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</h3>
            </div>
        @elseif(session('not_found'))
            <div class="alert alert-success mt-2">
                Tyidak ada tagihan / ID Salah.
            </div>
        @endif
    </div>
</div>
@endsection
