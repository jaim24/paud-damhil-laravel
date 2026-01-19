@extends('layouts.admin')

@section('title', 'Rekap Absensi Bulanan')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">📊 Rekap Bulanan</h2>
            <p class="text-slate-500">Rekap kehadiran guru bulan {{ Carbon\Carbon::createFromDate($year, $month, 1)->isoFormat('MMMM Y') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('attendances.index') }}" class="px-4 py-2 bg-slate-500 hover:bg-slate-600 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <i class="ph ph-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('attendances.export', ['month' => $month, 'year' => $year]) }}" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <i class="ph ph-file-xls"></i> Export Excel
            </a>
        </div>
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

    <!-- Info -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-blue-700">
        <i class="ph ph-info"></i> Total hari kerja bulan ini: <strong>{{ $workingDays }} hari</strong>
    </div>

    <!-- Monthly Summary Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200">
            <h3 class="font-bold text-slate-800">Rekap Kehadiran Per Guru</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">No</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Nama Guru</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase">NIP</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase bg-green-50">Hadir</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase bg-amber-50">Terlambat</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase bg-blue-50">Izin</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase bg-purple-50">Sakit</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase bg-red-50">Alpha</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase">%</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($teachers as $index => $teacher)
                    @php
                        $hadir = $teacher->attendances->where('status', 'hadir')->count();
                        $terlambat = $teacher->attendances->where('status', 'terlambat')->count();
                        $izin = $teacher->attendances->where('status', 'izin')->count();
                        $sakit = $teacher->attendances->where('status', 'sakit')->count();
                        $alpha = $workingDays - ($hadir + $terlambat + $izin + $sakit);
                        $alpha = max(0, $alpha);
                        $percentage = $workingDays > 0 ? round((($hadir + $terlambat) / $workingDays) * 100) : 0;
                    @endphp
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 text-slate-600">{{ $index + 1 }}</td>
                        <td class="px-4 py-3">
                            <p class="font-bold text-slate-800">{{ $teacher->name }}</p>
                            <p class="text-xs text-slate-500">{{ $teacher->position ?? '-' }}</p>
                        </td>
                        <td class="px-4 py-3 text-center text-slate-600 font-mono">{{ $teacher->nip ?? '-' }}</td>
                        <td class="px-4 py-3 text-center font-bold text-green-600 bg-green-50">{{ $hadir }}</td>
                        <td class="px-4 py-3 text-center font-bold text-amber-600 bg-amber-50">{{ $terlambat }}</td>
                        <td class="px-4 py-3 text-center font-bold text-blue-600 bg-blue-50">{{ $izin }}</td>
                        <td class="px-4 py-3 text-center font-bold text-purple-600 bg-purple-50">{{ $sakit }}</td>
                        <td class="px-4 py-3 text-center font-bold text-red-600 bg-red-50">{{ $alpha }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <div class="w-16 bg-slate-200 rounded-full h-2">
                                    <div class="h-2 rounded-full {{ $percentage >= 80 ? 'bg-green-500' : ($percentage >= 60 ? 'bg-amber-500' : 'bg-red-500') }}" 
                                         style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="text-sm font-bold {{ $percentage >= 80 ? 'text-green-600' : ($percentage >= 60 ? 'text-amber-600' : 'text-red-600') }}">
                                    {{ $percentage }}%
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('attendances.show', ['teacher' => $teacher, 'month' => $month, 'year' => $year]) }}" 
                               class="text-sky-600 hover:text-sky-800" title="Detail">
                                <i class="ph ph-eye text-xl"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
