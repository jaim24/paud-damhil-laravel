@extends('layouts.admin')

@section('title', 'Daftar Tunggu SPMB')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 flex items-center gap-4">
        <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center">
            <i class="ph ph-hourglass-medium text-xl"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $stats['waiting'] }}</h3>
            <p class="text-slate-500 text-xs">Menunggu</p>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
            <i class="ph ph-calendar-check text-xl"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $stats['scheduled'] }}</h3>
            <p class="text-slate-500 text-xs">Terjadwal</p>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 flex items-center gap-4">
        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center">
            <i class="ph ph-check-circle text-xl"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $stats['passed'] }}</h3>
            <p class="text-slate-500 text-xs">Lulus</p>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 flex items-center gap-4">
        <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center">
            <i class="ph ph-arrow-right text-xl"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $stats['transferred'] }}</h3>
            <p class="text-slate-500 text-xs">Lanjut Admin</p>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 flex items-center gap-4">
        <div class="w-12 h-12 bg-sky-100 text-sky-600 rounded-xl flex items-center justify-center">
            <i class="ph ph-users text-xl"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $stats['total'] }}</h3>
            <p class="text-slate-500 text-xs">Total</p>
        </div>
    </div>
</div>

<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Daftar Tunggu SPMB</h2>
        <p class="text-slate-500 text-sm">Kelola calon pendaftar & jadwal observasi</p>
    </div>
</div>

<!-- Flash Message -->
@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
    <i class="ph ph-check-circle text-xl"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
    <i class="ph ph-warning text-xl"></i>
    <span>{{ session('error') }}</span>
</div>
@endif

<!-- Search & Filter -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
    <form action="{{ route('waitlist.admin.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
        <div class="flex-1">
            <div class="relative">
                <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari nama anak atau orang tua..."
                       class="w-full pl-11 pr-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
            </div>
        </div>
        <select name="status" class="px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
            <option value="">Semua Status</option>
            <option value="waiting" {{ request('status') == 'waiting' ? 'selected' : '' }}>Menunggu</option>
            <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
            <option value="passed" {{ request('status') == 'passed' ? 'selected' : '' }}>Lulus Observasi</option>
            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Tidak Lulus</option>
            <option value="transferred" {{ request('status') == 'transferred' ? 'selected' : '' }}>Lanjut Administrasi</option>
        </select>
        <button type="submit" class="px-5 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-medium rounded-xl transition-colors">
            <i class="ph ph-magnifying-glass mr-1"></i> Filter
        </button>
        @if(request('status') || request('search'))
        <a href="{{ route('waitlist.admin.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium rounded-xl transition-colors text-center">Reset</a>
        @endif
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-slate-500 uppercase">#</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Nama Anak</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-slate-500 uppercase hidden md:table-cell">Orang Tua</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-slate-500 uppercase hidden lg:table-cell">Observasi</th>
                    <th class="px-4 py-4 text-center text-xs font-semibold text-slate-500 uppercase">Status</th>
                    <th class="px-4 py-4 text-center text-xs font-semibold text-slate-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($waitlists as $index => $w)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-4 py-4 text-slate-600">{{ $waitlists->firstItem() + $index }}</td>
                    <td class="px-4 py-4">
                        <p class="font-semibold text-slate-800">{{ $w->child_name }}</p>
                        <p class="text-xs text-slate-400">
                            {{ $w->gender == 'L' ? '👦' : '👧' }} 
                            {{ $w->birth_date ? $w->birth_date->format('d M Y') : '' }}
                        </p>
                    </td>
                    <td class="px-4 py-4 hidden md:table-cell">
                        <p class="text-slate-700 text-sm">{{ $w->father_name }}</p>
                        <p class="text-xs text-slate-400">📱 {{ $w->phone }}</p>
                    </td>
                    <td class="px-4 py-4 hidden lg:table-cell">
                        @if($w->observation_date)
                        <p class="text-sm text-slate-700">📅 {{ $w->observation_date->format('d M Y') }}</p>
                        <p class="text-xs text-slate-400">🕐 {{ $w->observation_date->format('H:i') }}</p>
                        @else
                        <span class="text-slate-400 text-sm">Belum dijadwalkan</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-{{ $w->status_color }}-100 text-{{ $w->status_color }}-700">
                            {{ $w->status_label }}
                        </span>
                    </td>
                    <td class="px-4 py-4">
                        <div class="flex items-center justify-center gap-1">
                            @if($w->status == 'waiting')
                            <!-- Schedule Observation Button -->
                            <button type="button" onclick="openScheduleModal({{ $w->id }}, '{{ $w->child_name }}')" 
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Jadwalkan Observasi">
                                <i class="ph ph-calendar-plus text-lg"></i>
                            </button>
                            @endif

                            @if($w->status == 'scheduled')
                            <!-- Mark Passed -->
                            <form action="{{ route('waitlist.admin.passed', $w->id) }}" method="POST" class="inline" 
                                  onsubmit="return confirm('Tandai {{ $w->child_name }} LULUS observasi?')">
                                @csrf
                                <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Lulus Observasi">
                                    <i class="ph ph-check-circle text-lg"></i>
                                </button>
                            </form>
                            <!-- Mark Failed -->
                            <form action="{{ route('waitlist.admin.failed', $w->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Tandai {{ $w->child_name }} TIDAK LULUS observasi?')">
                                @csrf
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Tidak Lulus">
                                    <i class="ph ph-x-circle text-lg"></i>
                                </button>
                            </form>
                            @endif

                            @if($w->status == 'passed')
                            <!-- Transfer to Administrasi -->
                            <form action="{{ route('waitlist.admin.transfer', $w->id) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Lanjutkan {{ $w->child_name }} ke tahap Administrasi?')">
                                @csrf
                                <button type="submit" class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition-colors" title="Lanjut Administrasi">
                                    <i class="ph ph-arrow-right text-lg"></i>
                                </button>
                            </form>
                            @endif

                            <!-- WhatsApp -->
                            @if(in_array($w->status, ['waiting', 'scheduled', 'passed']))
                            <a href="{{ route('waitlist.admin.whatsapp', $w->id) }}" target="_blank"
                               class="p-2 text-green-500 hover:bg-green-50 rounded-lg transition-colors" title="Hubungi WhatsApp">
                                <i class="ph ph-whatsapp-logo text-lg"></i>
                            </a>
                            @endif

                            <!-- Cancel -->
                            @if(!in_array($w->status, ['transferred', 'cancelled']))
                            <form action="{{ route('waitlist.admin.cancel', $w->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="button" onclick="showDeleteModal(this, '{{ $w->child_name }}')" 
                                        class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Batalkan">
                                    <i class="ph ph-trash text-lg"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                        <i class="ph ph-clipboard text-4xl mb-2 block"></i>
                        Belum ada data daftar tunggu.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($waitlists->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $waitlists->links() }}
    </div>
    @endif
</div>

<!-- Legend -->
<div class="mt-4 bg-slate-50 rounded-xl p-4 flex flex-wrap gap-4 text-sm">
    <span class="text-slate-500 font-medium">Aksi:</span>
    <span class="flex items-center gap-1 text-blue-600"><i class="ph ph-calendar-plus"></i> Jadwalkan</span>
    <span class="flex items-center gap-1 text-green-600"><i class="ph ph-check-circle"></i> Lulus</span>
    <span class="flex items-center gap-1 text-red-600"><i class="ph ph-x-circle"></i> Tidak Lulus</span>
    <span class="flex items-center gap-1 text-purple-600"><i class="ph ph-arrow-right"></i> Lanjut Admin</span>
    <span class="flex items-center gap-1 text-green-500"><i class="ph ph-whatsapp-logo"></i> WhatsApp</span>
</div>

<!-- Schedule Modal -->
<div id="scheduleModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
        <div class="bg-gradient-to-r from-blue-500 to-sky-600 px-6 py-4 rounded-t-2xl">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <i class="ph ph-calendar-plus"></i>
                Jadwalkan Observasi
            </h3>
        </div>
        <form id="scheduleForm" method="POST" class="p-6">
            @csrf
            <input type="hidden" id="scheduleWaitlistId" name="waitlist_id">
            
            <p class="text-slate-600 mb-4">Jadwalkan observasi untuk: <strong id="scheduleChildName"></strong></p>
            
            <div class="mb-4">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal & Waktu Observasi</label>
                <input type="datetime-local" name="observation_date" required
                       class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none">
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan (Opsional)</label>
                <textarea name="observation_notes" rows="2"
                          class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none"
                          placeholder="Catatan untuk orang tua..."></textarea>
            </div>
            
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 rounded-xl transition-colors">
                    <i class="ph ph-check mr-1"></i> Simpan Jadwal
                </button>
                <button type="button" onclick="closeScheduleModal()" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium rounded-xl transition-colors">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openScheduleModal(id, name) {
    document.getElementById('scheduleWaitlistId').value = id;
    document.getElementById('scheduleChildName').textContent = name;
    document.getElementById('scheduleForm').action = '/admin/waitlist/' + id + '/schedule';
    document.getElementById('scheduleModal').classList.remove('hidden');
    document.getElementById('scheduleModal').classList.add('flex');
}

function closeScheduleModal() {
    document.getElementById('scheduleModal').classList.add('hidden');
    document.getElementById('scheduleModal').classList.remove('flex');
}
</script>
@endsection
