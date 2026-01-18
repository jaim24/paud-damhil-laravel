@extends('layouts.admin')

@section('title', 'Detail Pendaftar')

@section('content')
<div class="max-w-4xl">
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
                    <p class="text-white/80">{{ $applicant->nickname ? '(' . $applicant->nickname . ')' : '' }} Pendaftar SPMB {{ $applicant->created_at->format('Y') }}</p>
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
        <div class="p-6 space-y-8">
            
            <!-- Section A: Data Murid -->
            <div>
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center text-sm">A</span>
                    Keterangan Murid
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="text-xs text-slate-500">Nama Lengkap</label>
                        <p class="font-semibold text-slate-800">{{ $applicant->child_name }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500">Nama Panggilan</label>
                        <p class="font-semibold text-slate-800">{{ $applicant->nickname ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500">Jenis Kelamin</label>
                        <p class="font-semibold text-slate-800">{{ $applicant->gender_label }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500">Tempat Lahir</label>
                        <p class="font-semibold text-slate-800">{{ $applicant->birth_place }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500">Tanggal Lahir</label>
                        <p class="font-semibold text-slate-800">{{ $applicant->birth_date->format('d F Y') }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500">Agama</label>
                        <p class="font-semibold text-slate-800">{{ $applicant->religion ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500">Kewarganegaraan</label>
                        <p class="font-semibold text-slate-800">{{ $applicant->citizenship }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500">Anak Ke</label>
                        <p class="font-semibold text-slate-800">{{ $applicant->child_order }} dari {{ $applicant->siblings_kandung + 1 }} bersaudara</p>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500">Bahasa Sehari-hari</label>
                        <p class="font-semibold text-slate-800">{{ $applicant->daily_language ?? '-' }}</p>
                    </div>
                </div>

                <!-- Keadaan Jasmani -->
                <div class="mt-4 p-4 bg-slate-50 rounded-xl">
                    <label class="text-xs text-slate-500 block mb-2">Keadaan Jasmani</label>
                    <div class="flex flex-wrap gap-4 text-sm">
                        <span class="text-slate-700"><strong>BB:</strong> {{ $applicant->weight ?? '-' }}</span>
                        <span class="text-slate-700"><strong>TB:</strong> {{ $applicant->height ?? '-' }}</span>
                        <span class="text-slate-700"><strong>Ling. Kepala:</strong> {{ $applicant->head_circumference ?? '-' }}</span>
                        <span class="text-slate-700"><strong>Gol. Darah:</strong> {{ $applicant->blood_type ?? '-' }}</span>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="mt-4">
                    <label class="text-xs text-slate-500">Alamat</label>
                    <p class="font-semibold text-slate-800">{{ $applicant->address_street }}</p>
                    <p class="text-slate-600 text-sm">
                        {{ $applicant->address_kelurahan ? 'Kel. ' . $applicant->address_kelurahan : '' }}
                        {{ $applicant->address_kecamatan ? ', Kec. ' . $applicant->address_kecamatan : '' }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                    <div>
                        <label class="text-xs text-slate-500">Tinggal Dengan</label>
                        <p class="font-semibold text-slate-800">{{ $applicant->living_with_label }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500">Jarak ke Sekolah</label>
                        <p class="font-semibold text-slate-800">{{ $applicant->distance_km ?? '-' }} KM / {{ $applicant->distance_minutes ?? '-' }} Menit</p>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500">Transportasi</label>
                        <p class="font-semibold text-slate-800">{{ $applicant->transportation ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500">Hobi</label>
                        <p class="font-semibold text-slate-800">{{ $applicant->hobby ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500">Cita-cita</label>
                        <p class="font-semibold text-slate-800">{{ $applicant->aspiration ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Section B: Data Orang Tua -->
            <div class="border-t border-slate-200 pt-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 bg-sky-100 text-sky-600 rounded-lg flex items-center justify-center text-sm">B</span>
                    Keterangan Orang Tua / Wali
                </h3>
                
                <!-- Ayah -->
                <div class="p-4 bg-blue-50 rounded-xl mb-4">
                    <h4 class="font-bold text-blue-700 mb-3">👨 Data Ayah</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                        <div>
                            <label class="text-xs text-blue-600">Nama</label>
                            <p class="font-semibold text-slate-800">{{ $applicant->father_name }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-blue-600">Tahun Lahir</label>
                            <p class="font-semibold text-slate-800">{{ $applicant->father_birth_year ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-blue-600">Pendidikan</label>
                            <p class="font-semibold text-slate-800">{{ $applicant->father_education ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-blue-600">Pekerjaan</label>
                            <p class="font-semibold text-slate-800">{{ $applicant->father_job ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-blue-600">Penghasilan</label>
                            <p class="font-semibold text-slate-800">{{ $applicant->father_income ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Ibu -->
                <div class="p-4 bg-pink-50 rounded-xl mb-4">
                    <h4 class="font-bold text-pink-700 mb-3">👩 Data Ibu</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                        <div>
                            <label class="text-xs text-pink-600">Nama</label>
                            <p class="font-semibold text-slate-800">{{ $applicant->mother_name }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-pink-600">Tahun Lahir</label>
                            <p class="font-semibold text-slate-800">{{ $applicant->mother_birth_year ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-pink-600">Pendidikan</label>
                            <p class="font-semibold text-slate-800">{{ $applicant->mother_education ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-pink-600">Pekerjaan</label>
                            <p class="font-semibold text-slate-800">{{ $applicant->mother_job ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-pink-600">Penghasilan</label>
                            <p class="font-semibold text-slate-800">{{ $applicant->mother_income ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Wali -->
                @if($applicant->guardian_name)
                <div class="p-4 bg-amber-50 rounded-xl">
                    <h4 class="font-bold text-amber-700 mb-3">👤 Data Wali</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                        <div>
                            <label class="text-xs text-amber-600">Nama</label>
                            <p class="font-semibold text-slate-800">{{ $applicant->guardian_name }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-amber-600">Hubungan</label>
                            <p class="font-semibold text-slate-800">{{ $applicant->guardian_relationship ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-amber-600">Pendidikan</label>
                            <p class="font-semibold text-slate-800">{{ $applicant->guardian_education ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-amber-600">Pekerjaan</label>
                            <p class="font-semibold text-slate-800">{{ $applicant->guardian_job ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Section C: Dokumen Pendukung -->
            @if($applicant->declaration_file)
            <div class="border-t border-slate-200 pt-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center text-sm">C</span>
                    Dokumen Pendukung
                </h3>
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white rounded-lg border border-slate-200 flex items-center justify-center text-red-500">
                            <i class="ph ph-file-pdf text-2xl"></i>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800">Surat Pernyataan</p>
                            <p class="text-xs text-slate-500">Diunggah: {{ $applicant->updated_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <a href="{{ asset('storage/' . $applicant->declaration_file) }}" target="_blank" 
                       class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold rounded-lg transition-colors flex items-center gap-2">
                        <i class="ph ph-eye"></i> Lihat
                    </a>
                </div>
            </div>
            @endif

            <!-- Section D: Kontak -->
            <div class="border-t border-slate-200 pt-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center text-sm">D</span>
                    Informasi Kontak
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="text-xs text-slate-500">No. HP / WhatsApp</label>
                        <p class="font-semibold text-slate-800">{{ $applicant->phone }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500">Email</label>
                        <p class="font-semibold text-slate-800">{{ $applicant->email ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500">Tanggal Mendaftar</label>
                        <p class="font-semibold text-slate-800">{{ $applicant->created_at->format('d F Y, H:i') }}</p>
                    </div>
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
