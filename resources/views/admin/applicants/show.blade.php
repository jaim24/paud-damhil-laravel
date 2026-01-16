@extends('layouts.admin')

@section('title', 'Detail Pendaftar')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('spmb.admin.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-700 mb-6 transition-colors">
        <i class="ph ph-arrow-left"></i>
        Kembali ke Daftar Pendaftar
    </a>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-orange-400 to-amber-500 p-6 text-white">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center text-3xl font-bold">
                    {{ strtoupper(substr($applicant->child_name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold">{{ $applicant->child_name }}</h2>
                    <p class="text-white/80">Pendaftar SPMB {{ $applicant->created_at->format('Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Status Badge -->
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <span class="text-slate-500">Status Pendaftaran:</span>
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold 
                @if($applicant->status == 'Pending') bg-amber-100 text-amber-700
                @elseif($applicant->status == 'Accepted') bg-green-100 text-green-700
                @else bg-red-100 text-red-700
                @endif">
                @if($applicant->status == 'Pending') ⏳ Menunggu Verifikasi
                @elseif($applicant->status == 'Accepted') ✅ DITERIMA
                @else ❌ DITOLAK
                @endif
            </span>
        </div>

        <!-- Details -->
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm text-slate-500">Nama Lengkap Anak</label>
                    <p class="font-semibold text-slate-800">{{ $applicant->child_name }}</p>
                </div>
                <div>
                    <label class="text-sm text-slate-500">Tanggal Lahir</label>
                    <p class="font-semibold text-slate-800">{{ $applicant->birth_date->format('d F Y') }}</p>
                </div>
                <div>
                    <label class="text-sm text-slate-500">Nama Orang Tua / Wali</label>
                    <p class="font-semibold text-slate-800">{{ $applicant->parent_name }}</p>
                </div>
                <div>
                    <label class="text-sm text-slate-500">Nomor HP / WhatsApp</label>
                    <p class="font-semibold text-slate-800">{{ $applicant->phone }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="text-sm text-slate-500">Alamat</label>
                    <p class="font-semibold text-slate-800">{{ $applicant->address }}</p>
                </div>
                <div>
                    <label class="text-sm text-slate-500">Tanggal Mendaftar</label>
                    <p class="font-semibold text-slate-800">{{ $applicant->created_at->format('d F Y, H:i') }}</p>
                </div>
            </div>

            @if($applicant->notes)
            <div class="p-4 bg-slate-50 rounded-xl">
                <label class="text-sm text-slate-500">Catatan Admin</label>
                <p class="text-slate-700">{{ $applicant->notes }}</p>
            </div>
            @endif
        </div>

        <!-- Actions -->
        @if($applicant->status == 'Pending')
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex gap-3">
            <form action="{{ route('spmb.admin.update_status', $applicant->id) }}" method="POST" class="flex-1">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="Accepted">
                <button type="submit" onclick="return confirm('Terima pendaftar ini?')"
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl transition-colors">
                    <i class="ph ph-check-circle text-xl"></i> Terima
                </button>
            </form>
            <form action="{{ route('spmb.admin.update_status', $applicant->id) }}" method="POST" class="flex-1">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="Rejected">
                <button type="submit" onclick="return confirm('Tolak pendaftar ini?')"
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-500 hover:bg-red-600 text-white font-bold rounded-xl transition-colors">
                    <i class="ph ph-x-circle text-xl"></i> Tolak
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
