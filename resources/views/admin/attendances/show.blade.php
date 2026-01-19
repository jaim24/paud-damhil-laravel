@extends('layouts.admin')

@section('title', 'Detail Absensi - ' . $teacher->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-slate-200 flex items-center justify-center overflow-hidden">
                @if($teacher->photo)
                    <img src="{{ asset('storage/' . $teacher->photo) }}" class="w-full h-full object-cover">
                @else
                    <span class="text-2xl text-slate-500 font-bold">{{ substr($teacher->name, 0, 1) }}</span>
                @endif
            </div>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">{{ $teacher->name }}</h2>
                <p class="text-slate-500">{{ $teacher->nip ?? 'NIP: -' }} • {{ $teacher->position ?? '-' }}</p>
            </div>
        </div>
        <a href="{{ route('attendances.monthly', ['month' => $month, 'year' => $year]) }}" class="px-4 py-2 bg-slate-500 hover:bg-slate-600 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i class="ph ph-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Month Picker -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
        <form method="GET" class="flex flex-wrap items-center gap-4">
            <div class="flex items-center gap-2">
                <label class="text-sm font-medium text-slate-600">Bulan:</label>
                <select name="month" class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none">
                    @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                        {{ Carbon\Carbon::createFromDate(null, $m, 1)->isoFormat('MMMM') }}
                    </option>
                    @endfor
                </select>
            </div>
            <div class="flex items-center gap-2">
                <label class="text-sm font-medium text-slate-600">Tahun:</label>
                <select name="year" class="px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none">
                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg font-medium transition-colors">
                <i class="ph ph-magnifying-glass"></i> Tampilkan
            </button>
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
            <p class="text-3xl font-bold text-green-600">{{ $stats['hadir'] }}</p>
            <p class="text-green-700 text-sm">Hadir</p>
        </div>
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-center">
            <p class="text-3xl font-bold text-amber-600">{{ $stats['terlambat'] }}</p>
            <p class="text-amber-700 text-sm">Terlambat</p>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-center">
            <p class="text-3xl font-bold text-blue-600">{{ $stats['izin'] }}</p>
            <p class="text-blue-700 text-sm">Izin</p>
        </div>
        <div class="bg-purple-50 border border-purple-200 rounded-xl p-4 text-center">
            <p class="text-3xl font-bold text-purple-600">{{ $stats['sakit'] }}</p>
            <p class="text-purple-700 text-sm">Sakit</p>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center">
            <p class="text-3xl font-bold text-red-600">{{ $stats['alpha'] }}</p>
            <p class="text-red-700 text-sm">Alpha</p>
        </div>
    </div>

    <!-- Attendance History -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200">
            <h3 class="font-bold text-slate-800">Riwayat Absensi - {{ Carbon\Carbon::createFromDate($year, $month, 1)->isoFormat('MMMM Y') }}</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Hari</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase">Masuk</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase">Pulang</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase">Durasi</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($attendances as $attendance)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 font-medium text-slate-800">{{ $attendance->date->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $attendance->date->isoFormat('dddd') }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($attendance->check_in)
                            <span class="font-mono font-bold text-green-600">{{ \Carbon\Carbon::parse($attendance->check_in)->format('H:i') }}</span>
                            @else
                            <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($attendance->check_out)
                            <span class="font-mono font-bold text-blue-600">{{ \Carbon\Carbon::parse($attendance->check_out)->format('H:i') }}</span>
                            @else
                            <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center text-slate-600">{{ $attendance->work_duration }}</td>
                        <td class="px-4 py-3 text-center">
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
                        </td>
                        <td class="px-4 py-3 text-slate-600 text-sm">{{ $attendance->notes ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                            Tidak ada data absensi untuk bulan ini
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
