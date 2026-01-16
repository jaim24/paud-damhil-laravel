<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest('published_date')->get();
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string|max:500',
            'content' => 'required|string',
            'published_date' => 'required|date',
            'category' => 'required|in:berita,pengumuman',
            'status' => 'required|in:draft,published',
        ]);

        $data['show_on_home'] = $request->has('show_on_home');

        News::create($data);
        return redirect()->route('news.index')->with('success', 'Berita berhasil ditambahkan!');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string|max:500',
            'content' => 'required|string',
            'published_date' => 'required|date',
            'category' => 'required|in:berita,pengumuman',
            'status' => 'required|in:draft,published',
        ]);

        $data['show_on_home'] = $request->has('show_on_home');

        $news->update($data);
        return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('news.index')->with('success', 'Berita berhasil dihapus!');
    }
}
