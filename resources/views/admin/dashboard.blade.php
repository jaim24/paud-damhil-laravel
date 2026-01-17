@extends('layouts.admin')

@section('title', 'Dashboard Ringkasan')

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Students -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200 flex items-center gap-4">
        <div class="w-14 h-14 bg-sky-100 text-sky-600 rounded-xl flex items-center justify-center">
            <i class="ph ph-users text-2xl"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $students_count }}</h3>
            <p class="text-slate-500 text-sm">Total Siswa</p>
        </div>
    </div>

    <!-- Teachers -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200 flex items-center gap-4">
        <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center">
            <i class="ph ph-chalkboard-teacher text-2xl"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $teachers_count }}</h3>
            <p class="text-slate-500 text-sm">Total Guru</p>
        </div>
    </div>

    <!-- Classes -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200 flex items-center gap-4">
        <div class="w-14 h-14 bg-green-100 text-green-600 rounded-xl flex items-center justify-center">
            <i class="ph ph-books text-2xl"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $classes_count }}</h3>
            <p class="text-slate-500 text-sm">Total Kelas</p>
        </div>
    </div>

    <!-- Applicants -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200 flex items-center gap-4">
        <div class="w-14 h-14 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center">
            <i class="ph ph-user-plus text-2xl"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $applicants_count }}</h3>
            <p class="text-slate-500 text-sm">Pendaftar SPMB</p>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Chart: Pendaftar per Bulan -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-bold text-slate-800">Pendaftar SPMB</h3>
                <p class="text-slate-500 text-sm">6 Bulan Terakhir</p>
            </div>
            <div class="w-10 h-10 bg-sky-100 text-sky-600 rounded-lg flex items-center justify-center">
                <i class="ph ph-chart-line-up text-xl"></i>
            </div>
        </div>
        <div style="height: 250px;">
            <canvas id="applicantsChart"></canvas>
        </div>
    </div>

    <!-- Chart: Status SPMB -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-bold text-slate-800">Status Pendaftar</h3>
                <p class="text-slate-500 text-sm">Distribusi Status SPMB</p>
            </div>
            <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center">
                <i class="ph ph-chart-pie text-xl"></i>
            </div>
        </div>
        <div style="height: 200px;" class="flex items-center justify-center">
            <canvas id="spmbStatusChart"></canvas>
        </div>
        <div class="flex justify-center gap-6 mt-4 text-sm">
            <span class="flex items-center gap-2"><span class="w-3 h-3 bg-amber-400 rounded-full"></span> Pending ({{ $spmbPending }})</span>
            <span class="flex items-center gap-2"><span class="w-3 h-3 bg-green-500 rounded-full"></span> Diterima ({{ $spmbAccepted }})</span>
            <span class="flex items-center gap-2"><span class="w-3 h-3 bg-red-500 rounded-full"></span> Ditolak ({{ $spmbRejected }})</span>
        </div>
    </div>
</div>

<!-- Charts Row 2 -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Chart: Status SPP -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-bold text-slate-800">Status Pembayaran SPP</h3>
                <p class="text-slate-500 text-sm">Lunas vs Belum Lunas</p>
            </div>
            <div class="w-10 h-10 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                <i class="ph ph-money text-xl"></i>
            </div>
        </div>
        <div style="height: 180px;" class="flex items-center justify-center">
            <canvas id="sppStatusChart"></canvas>
        </div>
        <div class="flex justify-center gap-8 mt-4 text-sm">
            <span class="flex items-center gap-2"><span class="w-3 h-3 bg-green-500 rounded-full"></span> Lunas ({{ $sppPaid }})</span>
            <span class="flex items-center gap-2"><span class="w-3 h-3 bg-red-500 rounded-full"></span> Belum Lunas ({{ $sppUnpaid }})</span>
        </div>
    </div>

    <!-- Chart: Siswa per Kelas -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-bold text-slate-800">Siswa per Kelas</h3>
                <p class="text-slate-500 text-sm">Distribusi Siswa</p>
            </div>
            <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center">
                <i class="ph ph-users-three text-xl"></i>
            </div>
        </div>
        <div style="height: 180px;">
            <canvas id="studentsChart"></canvas>
        </div>
    </div>
</div>

<!-- Recent Applicants Table -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-6">
    <div class="p-6 border-b border-slate-200 flex justify-between items-center">
        <h3 class="font-bold text-slate-800">Pendaftar SPMB Terbaru</h3>
        <a href="{{ route('spmb.admin.index') }}" class="text-sm text-sky-600 hover:text-sky-700 font-medium">
            Lihat semua <i class="ph ph-arrow-right"></i>
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Anak</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Orang Tua</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($applicants as $index => $a)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 text-slate-600">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">
                        <p class="font-semibold text-slate-800">{{ $a->child_name }}</p>
                        <p class="text-sm text-slate-400">{{ $a->birth_date ? $a->birth_date->format('d M Y') : '-' }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-slate-700">{{ $a->father_name }}</p>
                        <p class="text-sm text-slate-400">{{ $a->phone }}</p>
                    </td>
                    <td class="px-6 py-4 text-slate-600">{{ $a->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium 
                            @if($a->status == 'Accepted') bg-green-100 text-green-700
                            @elseif($a->status == 'Rejected') bg-red-100 text-red-700
                            @else bg-amber-100 text-amber-700
                            @endif">
                            {{ $a->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('spmb.admin.show', $a->id) }}" class="text-sm px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-colors">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                        <i class="ph ph-folder-open text-4xl mb-2 block"></i>
                        Belum ada data pendaftar terbaru.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Info Card -->
<div class="bg-gradient-to-r from-sky-500 to-blue-600 rounded-xl p-6 text-white">
    <div class="flex items-start gap-4">
        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="ph ph-info text-2xl"></i>
        </div>
        <div>
            <h3 class="font-bold text-lg mb-1">Selamat Datang di Panel Admin</h3>
            <p class="text-sky-100">Gunakan menu di sebelah kiri untuk mengelola data guru, siswa, kelas, dan pendaftar SPMB. Semua perubahan akan langsung tersimpan di database.</p>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Pendaftar per Bulan Chart
const applicantsCtx = document.getElementById('applicantsChart');
if (applicantsCtx) {
    new Chart(applicantsCtx, {
        type: 'line',
        data: {
            labels: @json($chartMonths),
            datasets: [{
                label: 'Pendaftar',
                data: @json($chartApplicants),
                borderColor: '#0ea5e9',
                backgroundColor: 'rgba(14, 165, 233, 0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#0ea5e9',
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
}

// Status SPMB Pie Chart
const spmbCtx = document.getElementById('spmbStatusChart');
if (spmbCtx) {
    new Chart(spmbCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Diterima', 'Ditolak'],
            datasets: [{
                data: [{{ $spmbPending ?? 0 }}, {{ $spmbAccepted ?? 0 }}, {{ $spmbRejected ?? 0 }}],
                backgroundColor: ['#fbbf24', '#22c55e', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            cutout: '60%'
        }
    });
}

// Status SPP Pie Chart
const sppCtx = document.getElementById('sppStatusChart');
if (sppCtx) {
    new Chart(sppCtx, {
        type: 'doughnut',
        data: {
            labels: ['Lunas', 'Belum Lunas'],
            datasets: [{
                data: [{{ $sppPaid ?? 0 }}, {{ $sppUnpaid ?? 0 }}],
                backgroundColor: ['#22c55e', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            cutout: '60%'
        }
    });
}

// Siswa per Kelas Bar Chart
const studentsCtx = document.getElementById('studentsChart');
if (studentsCtx) {
    new Chart(studentsCtx, {
        type: 'bar',
        data: {
            labels: @json($studentsByClass->pluck('class_group')),
            datasets: [{
                label: 'Siswa',
                data: @json($studentsByClass->pluck('count')),
                backgroundColor: ['#0ea5e9', '#8b5cf6', '#f97316', '#22c55e', '#ec4899'],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
}
</script>
@endsection
