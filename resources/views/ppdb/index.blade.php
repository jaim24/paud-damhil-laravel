@extends('layouts.app')

@section('title', 'Formulir Pendaftaran Murid Baru - SPMB')

@section('content')
<div class="min-h-screen py-8 bg-gradient-to-br from-purple-50 via-pink-50 to-sky-50">
    <div class="container max-w-4xl mx-auto px-4">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <span class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-100 to-pink-100 text-purple-600 px-4 py-2 rounded-full text-sm font-bold mb-4">
                📝 SPMB Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}
            </span>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-800 mb-2">
                Biodata Anak Didik Baru
            </h1>
            <p class="text-slate-500">Mohon diisi dengan lengkap oleh Orang Tua</p>
            
            @if(isset($tokenData))
            <div class="mt-4 inline-flex items-center gap-2 bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-medium">
                <i class="ph-fill ph-check-circle"></i>
                Token Valid: {{ $tokenData['child_name'] }}
            </div>
            @endif
        </div>

        <!-- Form -->
        <form action="{{ route('spmb.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Section A: Keterangan Murid -->
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-pink-500 px-6 py-4">
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <span class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">A</span>
                        Keterangan Murid
                    </h2>
                </div>
                
                <div class="p-6 space-y-6">
                    
                    <!-- 1. Nama -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                1a. Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="child_name" value="{{ old('child_name', $prefillData['child_name'] ?? $tokenData['child_name'] ?? '') }}" required
                                   class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all @error('child_name') border-red-500 @enderror">
                            @error('child_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">1b. Nama Panggilan</label>
                            <input type="text" name="nickname" value="{{ old('nickname') }}"
                                   class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all">
                        </div>
                    </div>

                    <!-- 2. Jenis Kelamin -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">2. Jenis Kelamin <span class="text-red-500">*</span></label>
                        <div class="flex gap-4">
                            @php $selectedGender = old('gender', $prefillData['gender'] ?? 'L'); @endphp
                            <label class="flex items-center gap-2 px-4 py-3 border-2 rounded-xl cursor-pointer transition-all {{ $selectedGender == 'L' ? 'border-blue-500 bg-blue-50' : 'border-slate-200' }}">
                                <input type="radio" name="gender" value="L" {{ $selectedGender == 'L' ? 'checked' : '' }} class="w-4 h-4">
                                <span>👦 Laki-laki</span>
                            </label>
                            <label class="flex items-center gap-2 px-4 py-3 border-2 rounded-xl cursor-pointer transition-all {{ $selectedGender == 'P' ? 'border-pink-500 bg-pink-50' : 'border-slate-200' }}">
                                <input type="radio" name="gender" value="P" {{ $selectedGender == 'P' ? 'checked' : '' }} class="w-4 h-4">
                                <span>👧 Perempuan</span>
                            </label>
                        </div>
                    </div>

                    <!-- 3. Kelahiran -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">3a. Tempat Lahir <span class="text-red-500">*</span></label>
                            <input type="text" name="birth_place" value="{{ old('birth_place', $prefillData['birth_place'] ?? '') }}" required
                                   class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all @error('birth_place') border-red-500 @enderror">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">3b. Tanggal Lahir <span class="text-red-500">*</span></label>
                            <input type="date" name="birth_date" value="{{ old('birth_date', $prefillData['birth_date'] ?? '') }}" required
                                   class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all @error('birth_date') border-red-500 @enderror">
                        </div>
                    </div>

                    <!-- 4. Agama & 5. Kewarganegaraan -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">4. Agama <span class="text-red-500">*</span></label>
                            <select name="religion" required class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all">
                                <option value="">-- Pilih Agama --</option>
                                <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('religion') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('religion') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('religion') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('religion') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('religion') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">5. Kewarganegaraan <span class="text-red-500">*</span></label>
                            <select name="citizenship" required class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all">
                                <option value="WNI" {{ old('citizenship', 'WNI') == 'WNI' ? 'selected' : '' }}>WNI</option>
                                <option value="WNA" {{ old('citizenship') == 'WNA' ? 'selected' : '' }}>WNA Keturunan</option>
                            </select>
                        </div>
                    </div>

                    <!-- 6. Jumlah Saudara -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">6. Jumlah Saudara</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <div>
                                <label class="text-xs text-slate-500 block mb-1">Kandung</label>
                                <input type="number" name="siblings_kandung" value="{{ old('siblings_kandung', 0) }}" min="0"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-lg text-center">
                            </div>
                            <div>
                                <label class="text-xs text-slate-500 block mb-1">Tiri</label>
                                <input type="number" name="siblings_tiri" value="{{ old('siblings_tiri', 0) }}" min="0"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-lg text-center">
                            </div>
                            <div>
                                <label class="text-xs text-slate-500 block mb-1">Angkat</label>
                                <input type="number" name="siblings_angkat" value="{{ old('siblings_angkat', 0) }}" min="0"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-lg text-center">
                            </div>
                            <div>
                                <label class="text-xs text-slate-500 block mb-1">Anak ke-</label>
                                <input type="number" name="child_order" value="{{ old('child_order', 1) }}" min="1"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-lg text-center">
                            </div>
                        </div>
                    </div>

                    <!-- 7. Bahasa Sehari-hari -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">7. Bahasa Sehari-hari di Keluarga</label>
                        <input type="text" name="daily_language" value="{{ old('daily_language') }}" placeholder="Contoh: Indonesia, Gorontalo"
                               class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all">
                    </div>

                    <!-- 8. Keadaan Jasmani -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">8. Keadaan Jasmani</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <div>
                                <label class="text-xs text-slate-500 block mb-1">Berat Badan</label>
                                <input type="text" name="weight" value="{{ old('weight') }}" placeholder="... kg"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-lg">
                            </div>
                            <div>
                                <label class="text-xs text-slate-500 block mb-1">Tinggi Badan</label>
                                <input type="text" name="height" value="{{ old('height') }}" placeholder="... cm"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-lg">
                            </div>
                            <div>
                                <label class="text-xs text-slate-500 block mb-1">Ling. Kepala</label>
                                <input type="text" name="head_circumference" value="{{ old('head_circumference') }}" placeholder="... cm"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-lg">
                            </div>
                            <div>
                                <label class="text-xs text-slate-500 block mb-1">Gol. Darah</label>
                                <select name="blood_type" class="w-full px-3 py-2 border border-slate-200 rounded-lg">
                                    <option value="">-</option>
                                    <option value="A" {{ old('blood_type') == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('blood_type') == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="AB" {{ old('blood_type') == 'AB' ? 'selected' : '' }}>AB</option>
                                    <option value="O" {{ old('blood_type') == 'O' ? 'selected' : '' }}>O</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 9. Alamat -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">9. Alamat <span class="text-red-500">*</span></label>
                        <div class="space-y-3">
                            <div>
                                <label class="text-xs text-slate-500 block mb-1">Jalan</label>
                                <input type="text" name="address_street" value="{{ old('address_street', $prefillData['address'] ?? '') }}" required
                                       class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all @error('address_street') border-red-500 @enderror"
                                       placeholder="Nama jalan, nomor rumah, RT/RW">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-xs text-slate-500 block mb-1">Kelurahan</label>
                                    <input type="text" name="address_kelurahan" value="{{ old('address_kelurahan') }}"
                                           class="w-full px-3 py-2 border border-slate-200 rounded-lg">
                                </div>
                                <div>
                                    <label class="text-xs text-slate-500 block mb-1">Kecamatan</label>
                                    <input type="text" name="address_kecamatan" value="{{ old('address_kecamatan') }}"
                                           class="w-full px-3 py-2 border border-slate-200 rounded-lg">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 10. Bertempat Tinggal Pada -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">10. Bertempat Tinggal Pada <span class="text-red-500">*</span></label>
                        <div class="flex flex-wrap gap-3">
                            <label class="flex items-center gap-2 px-4 py-2 border-2 rounded-lg cursor-pointer {{ old('living_with', 'orang_tua') == 'orang_tua' ? 'border-purple-500 bg-purple-50' : 'border-slate-200' }}">
                                <input type="radio" name="living_with" value="orang_tua" {{ old('living_with', 'orang_tua') == 'orang_tua' ? 'checked' : '' }}>
                                <span>Orang Tua</span>
                            </label>
                            <label class="flex items-center gap-2 px-4 py-2 border-2 rounded-lg cursor-pointer {{ old('living_with') == 'menumpang' ? 'border-purple-500 bg-purple-50' : 'border-slate-200' }}">
                                <input type="radio" name="living_with" value="menumpang" {{ old('living_with') == 'menumpang' ? 'checked' : '' }}>
                                <span>Menumpang</span>
                            </label>
                            <label class="flex items-center gap-2 px-4 py-2 border-2 rounded-lg cursor-pointer {{ old('living_with') == 'asrama' ? 'border-purple-500 bg-purple-50' : 'border-slate-200' }}">
                                <input type="radio" name="living_with" value="asrama" {{ old('living_with') == 'asrama' ? 'checked' : '' }}>
                                <span>Asrama</span>
                            </label>
                        </div>
                    </div>

                    <!-- 11. Jarak & 12. Transportasi -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">11. Jarak ke Sekolah</label>
                            <div class="flex gap-2">
                                <input type="text" name="distance_km" value="{{ old('distance_km') }}" placeholder="... KM"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-lg">
                                <input type="text" name="distance_minutes" value="{{ old('distance_minutes') }}" placeholder="... Menit"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-lg">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">12. Transportasi</label>
                            <input type="text" name="transportation" value="{{ old('transportation') }}" placeholder="Contoh: Diantar, Jalan kaki"
                                   class="w-full px-3 py-2 border border-slate-200 rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">13. Hobi</label>
                            <input type="text" name="hobby" value="{{ old('hobby') }}" placeholder="Hobi anak"
                                   class="w-full px-3 py-2 border border-slate-200 rounded-lg">
                        </div>
                    </div>

                    <!-- 14. Cita-cita -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">14. Cita-cita</label>
                        <input type="text" name="aspiration" value="{{ old('aspiration') }}" placeholder="Cita-cita anak"
                               class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all">
                    </div>

                </div>
            </div>

            <!-- Section B: Keterangan Orang Tua -->
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-sky-500 to-blue-500 px-6 py-4">
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <span class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">B</span>
                        Keterangan Orang Tua / Wali Murid
                    </h2>
                </div>
                
                <div class="p-6 space-y-6">
                    
                    <!-- 1. Nama Orang Tua -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">1. Nama Orang Tua Kandung <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs text-slate-500 block mb-1">Nama Ayah</label>
                                <input type="text" name="father_name" value="{{ old('father_name', $prefillData['father_name'] ?? '') }}" required
                                       class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none transition-all @error('father_name') border-red-500 @enderror">
                            </div>
                            <div>
                                <label class="text-xs text-slate-500 block mb-1">Nama Ibu</label>
                                <input type="text" name="mother_name" value="{{ old('mother_name', $prefillData['mother_name'] ?? '') }}" required
                                       class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none transition-all @error('mother_name') border-red-500 @enderror">
                            </div>
                        </div>
                    </div>

                    <!-- 2. Tahun Lahir -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs text-slate-500 block mb-1">Tahun Lahir Ayah</label>
                            <input type="text" name="father_birth_year" value="{{ old('father_birth_year') }}" placeholder="Contoh: 1985" maxlength="4"
                                   class="w-full px-3 py-2 border border-slate-200 rounded-lg">
                        </div>
                        <div>
                            <label class="text-xs text-slate-500 block mb-1">Tahun Lahir Ibu</label>
                            <input type="text" name="mother_birth_year" value="{{ old('mother_birth_year') }}" placeholder="Contoh: 1988" maxlength="4"
                                   class="w-full px-3 py-2 border border-slate-200 rounded-lg">
                        </div>
                    </div>

                    <!-- 3. Pendidikan Terakhir -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs text-slate-500 block mb-1">Pendidikan Terakhir Ayah</label>
                            <select name="father_education" class="w-full px-3 py-2 border border-slate-200 rounded-lg">
                                <option value="">-- Pilih --</option>
                                <option value="SD" {{ old('father_education') == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ old('father_education') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA/SMK" {{ old('father_education') == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                                <option value="D3" {{ old('father_education') == 'D3' ? 'selected' : '' }}>D3</option>
                                <option value="S1" {{ old('father_education') == 'S1' ? 'selected' : '' }}>S1</option>
                                <option value="S2" {{ old('father_education') == 'S2' ? 'selected' : '' }}>S2</option>
                                <option value="S3" {{ old('father_education') == 'S3' ? 'selected' : '' }}>S3</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs text-slate-500 block mb-1">Pendidikan Terakhir Ibu</label>
                            <select name="mother_education" class="w-full px-3 py-2 border border-slate-200 rounded-lg">
                                <option value="">-- Pilih --</option>
                                <option value="SD" {{ old('mother_education') == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ old('mother_education') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA/SMK" {{ old('mother_education') == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                                <option value="D3" {{ old('mother_education') == 'D3' ? 'selected' : '' }}>D3</option>
                                <option value="S1" {{ old('mother_education') == 'S1' ? 'selected' : '' }}>S1</option>
                                <option value="S2" {{ old('mother_education') == 'S2' ? 'selected' : '' }}>S2</option>
                                <option value="S3" {{ old('mother_education') == 'S3' ? 'selected' : '' }}>S3</option>
                            </select>
                        </div>
                    </div>

                    <!-- 4. Pekerjaan -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs text-slate-500 block mb-1">Pekerjaan Ayah</label>
                            <input type="text" name="father_job" value="{{ old('father_job', $prefillData['father_job'] ?? '') }}" placeholder="Contoh: PNS, Wiraswasta"
                                   class="w-full px-3 py-2 border border-slate-200 rounded-lg">
                        </div>
                        <div>
                            <label class="text-xs text-slate-500 block mb-1">Pekerjaan Ibu</label>
                            <input type="text" name="mother_job" value="{{ old('mother_job', $prefillData['mother_job'] ?? '') }}" placeholder="Contoh: IRT, Guru"
                                   class="w-full px-3 py-2 border border-slate-200 rounded-lg">
                        </div>
                    </div>

                    <!-- 5. Penghasilan -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs text-slate-500 block mb-1">Penghasilan Ayah</label>
                            <select name="father_income" class="w-full px-3 py-2 border border-slate-200 rounded-lg">
                                <option value="">-- Pilih --</option>
                                <option value="< 1 Juta" {{ old('father_income') == '< 1 Juta' ? 'selected' : '' }}>< 1 Juta</option>
                                <option value="1 - 3 Juta" {{ old('father_income') == '1 - 3 Juta' ? 'selected' : '' }}>1 - 3 Juta</option>
                                <option value="3 - 5 Juta" {{ old('father_income') == '3 - 5 Juta' ? 'selected' : '' }}>3 - 5 Juta</option>
                                <option value="5 - 10 Juta" {{ old('father_income') == '5 - 10 Juta' ? 'selected' : '' }}>5 - 10 Juta</option>
                                <option value="> 10 Juta" {{ old('father_income') == '> 10 Juta' ? 'selected' : '' }}>> 10 Juta</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs text-slate-500 block mb-1">Penghasilan Ibu</label>
                            <select name="mother_income" class="w-full px-3 py-2 border border-slate-200 rounded-lg">
                                <option value="">-- Pilih --</option>
                                <option value="Tidak Bekerja" {{ old('mother_income') == 'Tidak Bekerja' ? 'selected' : '' }}>Tidak Bekerja</option>
                                <option value="< 1 Juta" {{ old('mother_income') == '< 1 Juta' ? 'selected' : '' }}>< 1 Juta</option>
                                <option value="1 - 3 Juta" {{ old('mother_income') == '1 - 3 Juta' ? 'selected' : '' }}>1 - 3 Juta</option>
                                <option value="3 - 5 Juta" {{ old('mother_income') == '3 - 5 Juta' ? 'selected' : '' }}>3 - 5 Juta</option>
                                <option value="> 5 Juta" {{ old('mother_income') == '> 5 Juta' ? 'selected' : '' }}>> 5 Juta</option>
                            </select>
                        </div>
                    </div>

                    <!-- 6. Wali Murid -->
                    <div class="pt-4 border-t border-slate-200">
                        <label class="block text-sm font-semibold text-slate-700 mb-3">6. Wali Murid (jika ada)</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs text-slate-500 block mb-1">Nama Wali</label>
                                <input type="text" name="guardian_name" value="{{ old('guardian_name') }}"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-lg">
                            </div>
                            <div>
                                <label class="text-xs text-slate-500 block mb-1">Hubungan Keluarga</label>
                                <input type="text" name="guardian_relationship" value="{{ old('guardian_relationship') }}" placeholder="Contoh: Paman, Nenek"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-lg">
                            </div>
                            <div>
                                <label class="text-xs text-slate-500 block mb-1">Pendidikan Wali</label>
                                <input type="text" name="guardian_education" value="{{ old('guardian_education') }}"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-lg">
                            </div>
                            <div>
                                <label class="text-xs text-slate-500 block mb-1">Pekerjaan Wali</label>
                                <input type="text" name="guardian_job" value="{{ old('guardian_job') }}"
                                       class="w-full px-3 py-2 border border-slate-200 rounded-lg">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Section C: Kontak -->
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-emerald-500 px-6 py-4">
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <span class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">C</span>
                        Informasi Kontak
                    </h2>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <i class="ph ph-whatsapp-logo text-green-500"></i> No. HP (WhatsApp) <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" name="phone" value="{{ old('phone', $prefillData['phone'] ?? $tokenData['phone'] ?? '') }}" required
                                   class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 outline-none transition-all @error('phone') border-red-500 @enderror"
                                   placeholder="08xxxxxxxxxx">
                            @error('phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 outline-none transition-all"
                                   placeholder="email@contoh.com">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-bold text-lg rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                <i class="ph ph-paper-plane-tilt text-xl"></i>
                Kirim Pendaftaran
            </button>

            <!-- Links -->
            <div class="text-center space-y-2">
                <a href="{{ route('spmb.status') }}" class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-700 font-semibold">
                    🔍 Sudah mendaftar? Cek Status Pendaftaran
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
