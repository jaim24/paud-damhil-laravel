<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::getSettings();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Sanitize coordinates (replace comma with dot if user inputs 1,23)
        if ($request->has('school_latitude')) {
            $request->merge(['school_latitude' => str_replace(',', '.', $request->school_latitude)]);
        }
        if ($request->has('school_longitude')) {
            $request->merge(['school_longitude' => str_replace(',', '.', $request->school_longitude)]);
        }

        $data = $request->validate([
            'school_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'welcome_text' => 'required|string|max:255',
            'sub_text' => 'nullable|string',
            'contact_phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'contact_address' => 'nullable|string',
            'about' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            // SPMB Settings
            'spmb_status' => 'required|in:open,closed,waitlist_only',
            'spmb_quota' => 'nullable|integer|min:1',
            'spmb_start_date' => 'nullable|date',
            'spmb_end_date' => 'nullable|date',
            'spmb_closed_message' => 'nullable|string',
            // Payment Settings
            'bank_name' => 'nullable|string|max:100',
            'bank_account' => 'nullable|string|max:50',
            'bank_holder' => 'nullable|string|max:100',
            'registration_fee' => 'nullable|numeric|min:0',
            // Attendance Settings
            'school_latitude' => 'nullable|numeric',
            'school_longitude' => 'nullable|numeric',
            'geofence_radius' => 'nullable|integer|min:10|max:500',
            'work_start_time' => 'nullable|date_format:H:i',
            'work_end_time' => 'nullable|date_format:H:i',
            'late_tolerance_minutes' => 'nullable|integer|min:0|max:60',
        ]);

        $settings = Setting::first();
        
        if (!$settings) {
            $settings = new Setting();
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($settings->logo) {
                Storage::disk('public')->delete($settings->logo);
            }
            $data['logo'] = $request->file('logo')->store('settings', 'public');
        }

        $settings->fill($data);
        $settings->save();

        return redirect()->route('settings.index')->with('success', 'Pengaturan sekolah berhasil disimpan!');
    }
}
