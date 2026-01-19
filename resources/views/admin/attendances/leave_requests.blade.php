@extends('layouts.admin')

@section('title', 'Pengajuan Izin/Sakit')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">📬 Pengajuan Izin/Sakit</h2>
            <p class="text-slate-500">Kelola pengajuan izin dan sakit dari guru</p>
        </div>
        <a href="{{ route('attendances.index') }}" class="px-4 py-2 bg-slate-500 hover:bg-slate-600 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
            <i class="ph ph-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('attendances.leave_requests', ['status' => 'pending']) }}" 
           class="bg-white rounded-xl shadow-sm border-2 {{ $status == 'pending' ? 'border-amber-500' : 'border-slate-200' }} p-4 hover:border-amber-400 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm">Menunggu</p>
                    <p class="text-2xl font-bold text-amber-600">{{ $stats['pending'] }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center">
                    <i class="ph ph-hourglass text-2xl"></i>
                </div>
            </div>
        </a>
        <a href="{{ route('attendances.leave_requests', ['status' => 'approved']) }}"
           class="bg-white rounded-xl shadow-sm border-2 {{ $status == 'approved' ? 'border-green-500' : 'border-slate-200' }} p-4 hover:border-green-400 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm">Disetujui</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['approved'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center">
                    <i class="ph ph-check-circle text-2xl"></i>
                </div>
            </div>
        </a>
        <a href="{{ route('attendances.leave_requests', ['status' => 'rejected']) }}"
           class="bg-white rounded-xl shadow-sm border-2 {{ $status == 'rejected' ? 'border-red-500' : 'border-slate-200' }} p-4 hover:border-red-400 transition-colors">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm">Ditolak</p>
                    <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center">
                    <i class="ph ph-x-circle text-2xl"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
        <i class="ph ph-check-circle text-xl"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Requests Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200">
            <h3 class="font-bold text-slate-800">
                Daftar Pengajuan 
                @if($status == 'pending') <span class="text-amber-600">(Menunggu)</span>
                @elseif($status == 'approved') <span class="text-green-600">(Disetujui)</span>
                @elseif($status == 'rejected') <span class="text-red-600">(Ditolak)</span>
                @endif
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Guru</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Tanggal</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase">Jenis</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-slate-500 uppercase">Alasan</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-slate-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($requests as $request)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3">
                            <p class="font-bold text-slate-800">{{ $request->teacher->name ?? '-' }}</p>
                            <p class="text-xs text-slate-500">{{ $request->teacher->nip ?? '-' }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <p class="font-medium text-slate-800">{{ $request->start_date->format('d M Y') }}</p>
                            @if($request->start_date != $request->end_date)
                            <p class="text-xs text-slate-500">s/d {{ $request->end_date->format('d M Y') }} ({{ $request->duration_days }} hari)</p>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($request->type == 'izin')
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-700">Izin</span>
                            @elseif($request->type == 'sakit')
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-purple-100 text-purple-700">Sakit</span>
                            @else
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-teal-100 text-teal-700">Cuti</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <p class="text-slate-700 text-sm max-w-xs truncate" title="{{ $request->reason }}">{{ $request->reason }}</p>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($request->status == 'pending')
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-amber-100 text-amber-700">Menunggu</span>
                            @elseif($request->status == 'approved')
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700">Disetujui</span>
                            @else
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($request->status == 'pending')
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('attendances.approve_leave', $request) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="p-2 bg-green-100 hover:bg-green-200 text-green-600 rounded-lg transition-colors" title="Setujui">
                                        <i class="ph ph-check-circle text-xl"></i>
                                    </button>
                                </form>
                                <button type="button" onclick="showRejectModal({{ $request->id }})" 
                                        class="p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors" title="Tolak">
                                    <i class="ph ph-x-circle text-xl"></i>
                                </button>
                            </div>
                            @else
                            <span class="text-slate-400 text-sm">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            Tidak ada pengajuan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($requests->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $requests->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-2xl">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Tolak Pengajuan</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                <textarea name="admin_notes" rows="3" required
                          class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none"
                          placeholder="Masukkan alasan penolakan..."></textarea>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="closeRejectModal()" class="flex-1 px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg font-medium transition-colors">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-medium transition-colors">
                    Tolak
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showRejectModal(id) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = `/admin/attendances/leave-requests/${id}/reject`;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeRejectModal() {
    const modal = document.getElementById('rejectModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
@endsection
