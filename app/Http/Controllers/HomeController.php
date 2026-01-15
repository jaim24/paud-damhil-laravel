<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $settings = Setting::first();
        if(!$settings) {
            // Create default setting in memory if db empty just in case
            $settings = new Setting(); 
        }
        return view('home', compact('settings'));
    }
}
