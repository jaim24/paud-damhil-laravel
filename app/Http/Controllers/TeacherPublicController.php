<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherPublicController extends Controller
{
    public function index()
    {
        // Mengambil semua data guru, diurutkan terbaru
        $teachers = Teacher::latest()->get();
        return view('teachers.public_index', compact('teachers'));
    }
}
