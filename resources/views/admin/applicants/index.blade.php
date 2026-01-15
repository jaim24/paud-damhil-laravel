@extends('layouts.admin')

@section('title', 'Data Pendaftar PPDB')

@section('content')
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h3 style="margin:0">List Pendaftar Masuk</h3>
        <button class="btn btn-primary" onclick="window.print()" style="padding:8px 20px; font-size:0.9rem">
            <i class="ph ph-printer"></i> Cetak Laporan
        </button>
    </div>

    <table class="table-modern">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Anak</th>
                <th>Tanggal Lahir</th>
                <th>Orang Tua</th>
                <th>Alamat</th>
                <th>Tanggal Daftar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applicants as $index => $a)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><b>{{ $a->child_name }}</b></td>
                <td>{{ \Carbon\Carbon::parse($a->birth_date)->format('d/m/Y') }}</td>
                <td>
                    {{ $a->parent_name }}<br>
                    <small style="color:var(--text-main)"><i class="ph ph-phone"></i> {{ $a->phone }}</small>
                </td>
                <td>{{ Str::limit($a->address, 30) }}</td>
                <td>{{ $a->created_at->format('d M Y') }}</td>
                <td><span class="badge badge-warning">{{ $a->status }}</span></td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="padding:40px;">Belum ada pendaftar.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
