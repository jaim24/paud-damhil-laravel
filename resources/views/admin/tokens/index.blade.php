@extends('layouts.admin')

@section('title', 'Kelola Token Akses')

@section('content')
<!-- Header -->
<div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Kelola Token Akses SPMB</h2>
        <p class="text-slate-500 text-sm">Generate dan kelola kode akses pendaftaran</p>
    </div>
    <button onclick="document.getElementById('generateModal').classList.remove('hidden')" 
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-purple-500 hover:bg-purple-600 text-white font-medium rounded-xl transition-colors shadow-sm">
        <i class="ph ph-plus-circle"></i>
        Generate Token Manual
    </button>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 flex items-center gap-4">
        <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center">
            <i class="ph ph-key text-xl"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $stats['total'] }}</h3>
            <p class="text-slate-500 text-sm">Total Token</p>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 flex items-center gap-4">
        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center">
            <i class="ph ph-check-circle text-xl"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $stats['active'] }}</h3>
            <p class="text-slate-500 text-sm">Token Aktif</p>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 flex items-center gap-4">
        <div class="w-12 h-12 bg-slate-100 text-slate-600 rounded-xl flex items-center justify-center">
            <i class="ph ph-clock-counter-clockwise text-xl"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $stats['used'] }}</h3>
            <p class="text-slate-500 text-sm">Sudah Digunakan</p>
        </div>
    </div>
</div>

<!-- Search & Filter -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
    <form action="{{ route('tokens.admin.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
        <div class="flex-1">
            <div class="relative">
                <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari token, nama, atau no HP..."
                       class="w-full pl-11 pr-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-all">
            </div>
        </div>
        <select name="status" class="px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
            <option value="">Semua Status</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="used" {{ request('status') == 'used' ? 'selected' : '' }}>Sudah Digunakan</option>
        </select>
        <button type="submit" class="px-5 py-2.5 bg-purple-500 hover:bg-purple-600 text-white font-medium rounded-xl transition-colors">
            <i class="ph ph-magnifying-glass mr-1"></i> Filter
        </button>
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 lg:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Token</th>
                    <th class="px-4 lg:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Anak</th>
                    <th class="px-4 lg:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider hidden sm:table-cell">No HP</th>
                    <th class="px-4 lg:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider hidden md:table-cell">Dibuat</th>
                    <th class="px-4 lg:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 lg:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($tokens as $token)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-4 lg:px-6 py-4">
                        <div class="flex items-center gap-2">
                            <code class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg font-mono font-bold tracking-wider">{{ $token->token }}</code>
                            <button onclick="copyToken('{{ $token->token }}')" class="p-1.5 text-slate-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition-colors" title="Salin">
                                <i class="ph ph-copy text-lg"></i>
                            </button>
                        </div>
                    </td>
                    <td class="px-4 lg:px-6 py-4">
                        <p class="font-semibold text-slate-800">{{ $token->child_name }}</p>
                        @if($token->waitlist_id)
                        <p class="text-xs text-slate-400">dari Waitlist</p>
                        @endif
                    </td>
                    <td class="px-4 lg:px-6 py-4 text-slate-600 hidden sm:table-cell">{{ $token->phone }}</td>
                    <td class="px-4 lg:px-6 py-4 text-slate-500 text-sm hidden md:table-cell">{{ $token->created_at->format('d M Y H:i') }}</td>
                    <td class="px-4 lg:px-6 py-4">
                        @if($token->is_used)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                            <i class="ph-fill ph-check-circle mr-1"></i> Digunakan
                        </span>
                        @elseif($token->expires_at && $token->expires_at->isPast())
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-600">
                            <i class="ph-fill ph-clock mr-1"></i> Kadaluarsa
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                            <i class="ph-fill ph-check-circle mr-1"></i> Aktif
                        </span>
                        @endif
                    </td>
                    <td class="px-4 lg:px-6 py-4">
                        @if(!$token->is_used)
                        <form action="{{ route('tokens.admin.destroy', $token->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus token ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                <i class="ph ph-trash text-lg"></i>
                            </button>
                        </form>
                        @else
                        <span class="text-slate-400 text-sm">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                        <i class="ph ph-key text-4xl mb-2 block"></i>
                        Belum ada token. Klik "Generate Token Manual" untuk membuat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($tokens->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $tokens->links() }}
    </div>
    @endif
</div>

<!-- Generate Manual Modal -->
<div id="generateModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-800">Generate Token Manual</h3>
            <button onclick="document.getElementById('generateModal').classList.add('hidden')" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg">
                <i class="ph ph-x text-xl"></i>
            </button>
        </div>
        <form action="{{ route('tokens.admin.generate_manual') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Anak <span class="text-red-500">*</span></label>
                <input type="text" name="child_name" required
                       class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-all"
                       placeholder="Masukkan nama anak">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">No HP (WhatsApp) <span class="text-red-500">*</span></label>
                <input type="text" name="phone" required
                       class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-all"
                       placeholder="08xxxxxxxxxx">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan <span class="text-slate-400 font-normal">(opsional)</span></label>
                <textarea name="notes" rows="2"
                          class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition-all resize-none"
                          placeholder="Catatan tambahan..."></textarea>
            </div>
            <button type="submit" class="w-full py-3 bg-purple-500 hover:bg-purple-600 text-white font-bold rounded-xl transition-colors">
                <i class="ph ph-key mr-2"></i> Generate Token
            </button>
        </form>
    </div>
</div>

<script>
function copyToken(token) {
    navigator.clipboard.writeText(token).then(() => {
        alert('Token berhasil disalin: ' + token);
    });
}

// Close modal on overlay click
document.getElementById('generateModal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
    }
});
</script>
@endsection
