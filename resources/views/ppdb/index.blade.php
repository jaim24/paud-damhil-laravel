@extends('layouts.app')

@section('title', 'Pendaftaran Murid Baru')

@section('content')
<div class="container mt-2">
    <div class="form-card">
        <h2 class="text-center mb-1">Pendaftaran Murid Baru</h2>
        
        <form action="{{ route('ppdb.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap Anak</label>
                <input type="text" name="child_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="birth_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Nama Orang Tua</label>
                <input type="text" name="parent_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Nomor HP</label>
                <input type="tel" name="phone" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="address" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%">Kirim Pendaftaran</button>
        </form>
    </div>
</div>
@endsection
