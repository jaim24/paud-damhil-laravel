@extends('layouts.admin')

@section('title', 'Tambah Guru Baru')

@section('content')
<div class="card" style="max-width: 800px;">
    <h3 style="margin-bottom: 25px; border-bottom: 1px solid #eee; padding-bottom: 15px;">Form Tambah Guru</h3>
    
    <form action="{{ route('teachers.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name" class="form-control" placeholder="Contoh: Budi Santoso, S.Pd" required>
        </div>
        
        <div class="form-group">
            <label>Jabatan</label>
            <select name="position" class="form-control">
                <option value="Guru Kelas">Guru Kelas</option>
                <option value="Kepala Sekolah">Kepala Sekolah</option>
                <option value="Staf Administrasi">Staf Administrasi</option>
            </select>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary">
                <i class="ph ph-floppy-disk"></i> Simpan Data
            </button>
            <a href="{{ route('teachers.index') }}" class="btn btn-outline" style="border: 1px solid #e2e8f0;">
                <i class="ph ph-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection
