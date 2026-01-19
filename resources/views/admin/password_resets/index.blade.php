@extends('layouts.admin')

@section('title', 'Permintaan Reset Password')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">🔑 Permintaan Reset Password</h2>
            <p class="text-slate-500">Daftar guru yang meminta reset password akun mobile app</p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
        <i class="ph ph-check-circle text-xl"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Request List -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-red-50 flex items-center justify-between">
            <h3 class="font-bold text-red-800 flex items-center gap-2">
                <i class="ph ph-warning-circle text-lg"></i>
                Permintaan Pending ({{ count($requests) }})
            </h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase">Guru</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase">Waktu Request</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($requests as $index => $teacher)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 text-slate-500">{{ $index + 1 }}</td>
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
                                    <p class="text-xs text-slate-500 font-mono">{{ $teacher->nip }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">
                                {{ $teacher->password_reset_requested_at->diffForHumans() }}
                            </span>
                            <p class="text-xs text-slate-400 mt-1">
                                {{ $teacher->password_reset_requested_at->format('d M Y, H:i') }}
                            </p>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.password-resets.reset', $teacher) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mereset password guru ini menjadi 123456?')">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-lg font-medium transition-colors text-sm shadow-sm flex items-center gap-2 ml-auto">
                                    <i class="ph ph-arrow-counter-clockwise"></i> Reset Password
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <i class="ph ph-check-circle text-5xl mb-3 text-green-300"></i>
                                <span class="text-slate-500 font-medium">Tidak ada permintaan reset password</span>
                                <p class="text-sm mt-1">Semua akun aman terkendali</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
