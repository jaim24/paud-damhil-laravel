@extends('layouts.admin')

@section('title', 'Tambah Kelas Baru')

@section('content')
<div class="card" style="max-width: 800px;">
    <h3 style="margin-bottom: 25px; border-bottom: 1px solid #eee; padding-bottom: 15px;">Form Tambah Kelas</h3>

    <form action="{{ route('classes.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Kelas</label>
            <input type="text" name="name" class="form-control" placeholder="Contoh: Kelompok A (Usia 4-5 Tahun)" required>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary">
                <i class="ph ph-floppy-disk"></i> Simpan Data
            </button>
            <a href="{{ route('classes.index') }}" class="btn btn-outline" style="border: 1px solid #e2e8f0;">
                <i class="ph ph-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection
