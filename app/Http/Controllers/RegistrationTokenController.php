<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistrationToken;
use App\Models\Waitlist;
use Illuminate\Support\Facades\Auth;

class RegistrationTokenController extends Controller
{
    // Admin: List all tokens
    public function index(Request $request)
    {
        $query = RegistrationToken::with(['waitlist', 'creator'])->latest();

        // Filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active();
            } elseif ($request->status === 'used') {
                $query->used();
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('token', 'like', "%{$search}%")
                  ->orWhere('child_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $tokens = $query->paginate(15)->withQueryString();
        
        $stats = [
            'total' => RegistrationToken::count(),
            'active' => RegistrationToken::active()->count(),
            'used' => RegistrationToken::used()->count(),
        ];

        return view('admin.tokens.index', compact('tokens', 'stats'));
    }

    // Generate token from waitlist
    public function generateFromWaitlist($id)
    {
        $waitlist = Waitlist::findOrFail($id);
        
        // Check if token already exists for this waitlist
        $existingToken = RegistrationToken::where('waitlist_id', $waitlist->id)
                                           ->where('is_used', false)
                                           ->first();
        
        if ($existingToken) {
            return back()->with('error', "Token sudah ada untuk {$waitlist->child_name}: {$existingToken->token}");
        }

        $token = RegistrationToken::create([
            'token' => RegistrationToken::generateToken(),
            'waitlist_id' => $waitlist->id,
            'child_name' => $waitlist->child_name,
            'phone' => $waitlist->phone,
            'expires_at' => now()->addDays(30), // Valid 30 hari
            'created_by' => Auth::id(),
        ]);

        return back()->with('success', "Token berhasil dibuat untuk {$waitlist->child_name}: {$token->token}");
    }

    // Generate token manually
    public function generateManual(Request $request)
    {
        $validated = $request->validate([
            'child_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string',
        ], [
            'child_name.required' => 'Nama anak wajib diisi',
            'phone.required' => 'Nomor HP wajib diisi',
        ]);

        $token = RegistrationToken::create([
            'token' => RegistrationToken::generateToken(),
            'child_name' => $validated['child_name'],
            'phone' => $validated['phone'],
            'notes' => $validated['notes'] ?? null,
            'expires_at' => now()->addDays(30),
            'created_by' => Auth::id(),
        ]);

        return back()->with('success', "Token berhasil dibuat: {$token->token}");
    }

    // Delete token
    public function destroy($id)
    {
        $token = RegistrationToken::findOrFail($id);
        
        if ($token->is_used) {
            return back()->with('error', 'Token yang sudah digunakan tidak bisa dihapus.');
        }
        
        $token->delete();
        
        return back()->with('success', 'Token berhasil dihapus.');
    }
}
