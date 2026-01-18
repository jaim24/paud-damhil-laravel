@extends('layouts.admin')

@section('title', 'Data Siswa')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="ph ph-users text-2xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ $activeStudents }}</p>
                <p class="text-sm text-slate-500">Siswa Aktif</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-sky-100 text-sky-600 rounded-xl flex items-center justify-center">
                <i class="ph ph-gender-male text-2xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ $maleCount }}</p>
                <p class="text-sm text-slate-500">Laki-laki</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-pink-100 text-pink-600 rounded-xl flex items-center justify-center">
                <i class="ph ph-gender-female text-2xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ $femaleCount }}</p>
                <p class="text-sm text-slate-500">Perempuan</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center">
                <i class="ph ph-graduation-cap text-2xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ $graduatedStudents }}</p>
                <p class="text-sm text-slate-500">Lulus</p>
            </div>
        </div>
    </div>
</div>

<!-- Class Summary Cards -->
<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3 mb-6">
    @foreach($countPerClass as $className => $count)
    <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl p-4 text-white shadow-lg">
        <p class="text-2xl font-bold">{{ $count }}</p>
        <p class="text-sm text-purple-100">{{ $className }}</p>
    </div>
    @endforeach
</div>

<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Daftar Siswa per Kelas</h2>
        <p class="text-slate-500 text-sm">Total {{ $totalStudents }} siswa terdaftar</p>
    </div>
    <a href="{{ route('students.create') }}" 
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-medium rounded-xl transition-colors shadow-sm">
        <i class="ph ph-plus"></i>
        Tambah Siswa
    </a>
</div>

<!-- Filter & Search -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
    <form action="{{ route('students.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
        <!-- Search -->
        <div class="flex-1">
            <div class="relative">
                <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari nama, NISN, atau nama orang tua..."
                       class="w-full pl-11 pr-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
            </div>
        </div>
        
        <!-- Filter Kelas -->
        <div>
            <select name="class" onchange="this.form.submit()" 
                    class="px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
                <option value="">Semua Kelas</option>
                @foreach($classes as $class)
                    <option value="{{ $class }}" {{ $selectedClass == $class ? 'selected' : '' }}>{{ $class }}</option>
                @endforeach
            </select>
        </div>
        
        <!-- Filter Status -->
        <div>
            <select name="status" onchange="this.form.submit()" 
                    class="px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
                <option value="active" {{ $selectedStatus == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="graduated" {{ $selectedStatus == 'graduated' ? 'selected' : '' }}>Lulus</option>
                <option value="inactive" {{ $selectedStatus == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                <option value="all" {{ $selectedStatus == 'all' ? 'selected' : '' }}>Semua Status</option>
            </select>
        </div>
        
        <div class="flex gap-2">
            <button type="submit" class="px-5 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-medium rounded-xl transition-colors">
                <i class="ph ph-magnifying-glass"></i>
            </button>
            @if(request('search') || request('class') || request('status') !== 'active')
            <a href="{{ route('students.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium rounded-xl transition-colors">
                Reset
            </a>
            @endif
        </div>
    </form>
</div>

<!-- Flash Message -->
@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
    <i class="ph ph-check-circle text-xl"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<!-- Students Grouped by Class -->
@forelse($groupedByClass as $className => $students)
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-6">
    <!-- Class Header -->
    <div class="bg-gradient-to-r from-emerald-500 to-green-600 px-6 py-4">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="ph ph-chalkboard-teacher"></i>
                {{ $className ?: 'Tidak Ada Kelas' }}
            </h3>
            <span class="bg-white/20 text-white px-3 py-1 rounded-full text-sm font-medium">
                {{ count($students) }} siswa
            </span>
        </div>
    </div>
    
    <!-- Students Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">NISN</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Nama Siswa</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase">L/P</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Orang Tua</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($students as $index => $student)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-3 text-slate-600 text-sm">{{ $index + 1 }}</td>
                    <td class="px-6 py-3">
                        <span class="font-mono text-xs bg-slate-100 px-2 py-1 rounded">{{ $student->nisn ?: '-' }}</span>
                    </td>
                    <td class="px-6 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 {{ $student->gender == 'L' ? 'bg-gradient-to-br from-sky-400 to-blue-500' : 'bg-gradient-to-br from-pink-400 to-rose-500' }} rounded-full flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr($student->name, 0, 1)) }}
                            </div>
                            <span class="font-medium text-slate-800">{{ $student->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-3 text-center">
                        @if($student->gender == 'L')
                            <span class="text-sky-600">👦</span>
                        @else
                            <span class="text-pink-600">👧</span>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-sm text-slate-600">
                        {{ $student->parent_name ?: '-' }}
                        @if($student->parent_phone)
                            <br><span class="text-xs text-slate-400">{{ $student->parent_phone }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-center">
                        @if($student->status == 'active')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Aktif</span>
                        @elseif($student->status == 'graduated')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Lulus</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-center">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('students.edit', $student->id) }}" 
                               class="p-1.5 text-slate-500 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition-colors" title="Edit">
                                <i class="ph ph-pencil-simple text-lg"></i>
                            </a>
                            <form action="{{ route('students.destroy', $student->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="button" onclick="showDeleteModal(this, '{{ $student->name }}')"
                                        class="p-1.5 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <i class="ph ph-trash text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@empty
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
    <i class="ph ph-student text-5xl text-slate-300 mb-3 block"></i>
    @if(request('search'))
        <p class="text-slate-400 mb-4">Tidak ada siswa dengan kata kunci "{{ request('search') }}"</p>
        <a href="{{ route('students.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-colors">
            Reset Pencarian
        </a>
    @else
        <p class="text-slate-400 mb-4">Belum ada data siswa</p>
        <a href="{{ route('students.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition-colors">
            <i class="ph ph-plus"></i> Tambah Siswa
        </a>
    @endif
</div>
@endforelse
@endsection
