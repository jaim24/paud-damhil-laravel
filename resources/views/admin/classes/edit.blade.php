@extends('layouts.admin')

@section('title', 'Edit Data Kelas')

@section('content')
<div class="card" style="max-width: 800px;">
    <h3 style="margin-bottom: 25px; border-bottom: 1px solid #eee; padding-bottom: 15px;">Form Edit Kelas</h3>

    <form action="{{ route('classes.update', $schoolClass->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label>Nama Kelas</label>
            <input type="text" name="name" class="form-control" value="{{ $schoolClass->name }}" required>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary">
                <i class="ph ph-floppy-disk"></i> Update Data
            </button>
            <a href="{{ route('classes.index') }}" class="btn btn-outline" style="border: 1px solid #e2e8f0;">
                <i class="ph ph-arrow-left"></i> Kembali
            </a>
        </div>
    </form>
</div>
@endsection
