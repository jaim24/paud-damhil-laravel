<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Gallery;
use App\Models\News;

class HomeController extends Controller
{
    public function index()
    {
        $settings = Setting::first();
        if(!$settings) {
            $settings = new Setting(); 
        }
        
        // Get latest 6 active galleries for homepage
        $galleries = Gallery::active()
            ->onHome()
            ->latest('event_date')
            ->take(6)
            ->get();
        
        // Get latest 4 published news for homepage
        $news = News::published()
            ->onHome()
            ->latest('published_date')
            ->take(4)
            ->get();
        
        return view('home', compact('settings', 'galleries', 'news'));
    }
}
