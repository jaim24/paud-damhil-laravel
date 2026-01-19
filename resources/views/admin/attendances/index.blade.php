@extends('layouts.admin')

@section('title', 'Absensi Guru')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">📋 Absensi Guru</h2>
            <p class="text-slate-500">Rekap kehadiran guru hari ini</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('attendances.monthly') }}" class="px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <i class="ph ph-calendar"></i> Rekap Bulanan
            </a>
            <a href="{{ route('attendances.leave_requests') }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <i class="ph ph-envelope"></i> Pengajuan Izin
                @if($pendingLeaves ?? 0 > 0)
                <span class="bg-white text-amber-600 text-xs font-bold px-2 py-0.5 rounded-full">{{ $pendingLeaves }}</span>
                @endif
            </a>
        </div>
    </div>

    <!-- Date Picker -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
        <form method="GET" class="flex flex-wrap items-center gap-4">
            <div class="flex items-center gap-2">
                <label class="text-sm font-medium text-slate-600">Pilih Tanggal:</label>
                <input type="date" name="date" value="{{ $selectedDate->format('Y-m-d') }}" 
                       class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
            </div>
            <button type="submit" class="px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg font-medium transition-colors">
                <i class="ph ph-magnifying-glass"></i> Tampilkan
            </button>
            @if(!$selectedDate->isToday())
            <a href="{{ route('attendances.index') }}" class="px-4 py-2 text-slate-600 hover:text-slate-800">
                Kembali ke hari ini
            </a>
            @endif
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="bg-gradient-to-br from-slate-500 to-slate-600 rounded-xl p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-200 text-sm">Total Guru</p>
                    <p class="text-3xl font-bold">{{ $stats['total_teachers'] }}</p>
                </div>
                <i class="ph ph-users text-4xl text-slate-300"></i>
            </div>
        </div>
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-200 text-sm">Hadir</p>
                    <p class="text-3xl font-bold">{{ $stats['hadir'] }}</p>
                </div>
                <i class="ph ph-check-circle text-4xl text-green-300"></i>
            </div>
        </div>
        <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-200 text-sm">Terlambat</p>
                    <p class="text-3xl font-bold">{{ $stats['terlambat'] }}</p>
                </div>
                <i class="ph ph-clock text-4xl text-amber-300"></i>
            </div>
        </div>
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-200 text-sm">Izin/Sakit</p>
                    <p class="text-3xl font-bold">{{ ($stats['izin'] ?? 0) + ($stats['sakit'] ?? 0) }}</p>
                </div>
                <i class="ph ph-envelope text-4xl text-blue-300"></i>
            </div>
        </div>
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-4 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-200 text-sm">Alpha</p>
                    <p class="text-3xl font-bold">{{ $stats['alpha'] }}</p>
                </div>
                <i class="ph ph-x-circle text-4xl text-red-300"></i>
            </div>
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200">
            <h3 class="font-bold text-slate-800">
                Daftar Kehadiran - {{ $selectedDate->isoFormat('dddd, D MMMM Y') }}
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase">Guru</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase">Jabatan</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-slate-500 uppercase">Masuk</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-slate-500 uppercase">Pulang</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-slate-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-slate-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($teachers as $index => $teacher)
                    @php
                        $attendance = $attendances[$teacher->id] ?? null;
                    @endphp
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 text-slate-600">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center overflow-hidden">
                                    @if($teacher->photo)
                                        <img src="{{ asset('storage/' . $teacher->photo) }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-slate-500 font-bold">{{ substr($teacher->name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800">{{ $teacher->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $teacher->nip ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ $teacher->position ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($attendance && $attendance->check_in)
                                <span class="font-mono font-bold text-green-600">{{ \Carbon\Carbon::parse($attendance->check_in)->format('H:i') }}</span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($attendance && $attendance->check_out)
                                <span class="font-mono font-bold text-blue-600">{{ \Carbon\Carbon::parse($attendance->check_out)->format('H:i') }}</span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($attendance)
                                @php
                                    $statusColors = [
                                        'hadir' => 'bg-green-100 text-green-700',
                                        'terlambat' => 'bg-amber-100 text-amber-700',
                                        'izin' => 'bg-blue-100 text-blue-700',
                                        'sakit' => 'bg-purple-100 text-purple-700',
                                        'alpha' => 'bg-red-100 text-red-700',
                                    ];
                                @endphp
                                <span class="px-3 py-1 text-xs font-bold rounded-full {{ $statusColors[$attendance->status] ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700">Alpha</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('attendances.show', $teacher) }}" 
                               class="text-sky-600 hover:text-sky-800" title="Lihat Detail">
                                <i class="ph ph-eye text-xl"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                            Tidak ada data guru
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
