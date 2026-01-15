@extends('layouts.admin')

@section('title', 'Tambah Siswa Baru')

@section('content')
<div class="card" style="max-width: 800px;">
    <h3 style="margin-bottom: 25px; border-bottom: 1px solid #eee; padding-bottom: 15px;">Form Tambah Siswa</h3>

    <form action="{{ route('students.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>NISN</label>
            <input type="text" name="nisn" class="form-control" placeholder="Nomor Induk Siswa Nasional" required>
        </div>

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name" class="form-control" placeholder="Nama Lengkap Siswa" required>
        </div>

        <div class="form-group">
            <label>Kelas</label>
            <select name="class_group" class="form-control">
                @foreach($classes as $class)
                    <option value="{{ $class->name }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary">
                <i class="ph ph-floppy-disk"></i> Simpan Data
            </button>
            <a href="{{ route('students.index') }}" class="btn btn-outline" style="border: 1px solid #e2e8f0;">
                <i class="ph ph-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection
