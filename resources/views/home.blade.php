@extends('layouts.app')

@section('title', 'Beranda - PAUD Damhil UNG')

@section('content')
<!-- Hero Section -->
<section class="hero">
    <div class="container">
         <span style="display: inline-block; background: #ffffff; border: 1px solid #e2e8f0; color: var(--primary); padding: 8px 20px; border-radius: 50px; font-weight: 700; font-size: 0.85rem; margin-bottom: 25px; box-shadow: var(--shadow-sm); animation: fadeUp 0.8s ease-out backwards;">
            <i class="ph-fill ph-star" style="color:var(--accent)"></i> Pendidikan Anak Usia Dini Terbaik
        </span>
        <h1>{{ $settings->welcome_text ?? 'Selamat Datang di PAUD Damhil UNG' }}</h1>
        <p>{{ $settings->sub_text ?? 'Membentuk Generasi Cerdas...' }}</p>
        
        <div class="hero-btns">
            <a href="{{ route('ppdb.index') }}" class="btn btn-primary">
                Daftar Sekarang <i class="ph ph-arrow-right" style="margin-left:8px; vertical-align: middle;"></i>
            </a>
            <a href="{{ route('check.spp') }}" class="btn btn-outline" style="background:white; border-color:#e2e8f0; color:var(--secondary)">
                <i class="ph ph-magnifying-glass" style="margin-right:8px; vertical-align: middle;"></i> Cek SPP
            </a>
        </div>
    </div>
</section>

<!-- Stats Section (Floating) -->
<section class="container" style="position: relative; margin-top: -40px; z-index: 10;">
    <div style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 20px 40px -10px rgba(0,0,0,0.1); display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; text-align: center; animation: fadeUp 1s ease-out 0.6s backwards;">
        <div>
            <h2 class="text-gradient" style="font-size: 2.5rem; margin-bottom: 5px;">10+</h2>
            <p style="color: #64748B; font-weight: 600;">Tahun Pengalaman</p>
        </div>
        <div style="border-left: 1px solid #eee; border-right: 1px solid #eee;">
            <h2 class="text-gradient" style="font-size: 2.5rem; margin-bottom: 5px;">500+</h2>
            <p style="color: #64748B; font-weight: 600;">Alumni Sukses</p>
        </div>
        <div>
            <h2 class="text-gradient" style="font-size: 2.5rem; margin-bottom: 5px;">15</h2>
            <p style="color: #64748B; font-weight: 600;">Guru Profesional</p>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="container" style="margin-top: 100px; margin-bottom: 100px;">
    <div class="text-center" style="margin-bottom: 60px;">
        <h4 style="color: var(--primary); text-transform: uppercase; letter-spacing: 2px; font-weight: 800; font-size: 0.9rem;">Keunggulan Kami</h4>
        <h2 style="font-size: 2.5rem; margin-top: 10px;">Kenapa Memilih PAUD Damhil?</h2>
    </div>
    
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">
                <i class="ph-fill ph-smiley"></i>
            </div>
            <h3>Lingkungan Ceria</h3>
            <p style="color: #64748B; line-height: 1.7;">Suasana belajar yang didesain khusus agar anak merasa nyaman, aman, dan gembira setiap hari.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">
                <i class="ph-fill ph-book-open-text"></i>
            </div>
            <h3>Kurikulum Terbaik</h3>
            <p style="color: #64748B; line-height: 1.7;">Memadukan metode bermain dan belajar (play-based learning) untuk menstimulasi kecerdasan majemuk.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">
                <i class="ph-fill ph-certificate"></i>
            </div>
            <h3>Pengajar Profesional</h3>
            <p style="color: #64748B; line-height: 1.7;">Didukung oleh tenaga pendidik lulusan PG-PAUD yang berpengalaman dan penuh kasih sayang.</p>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section style="background: var(--secondary); padding: 80px 0; position: relative; overflow: hidden; margin-bottom: -100px; border-radius: 0;">
    <div style="position: absolute; top:0; left:0; width:100%; height:100%; background: url('https://www.transparenttextures.com/patterns/cubes.png'); opacity: 0.1;"></div>
    <div class="container text-center" style="position: relative; z-index: 5;">
        <h2 style="color: white; font-size: 2.5rem; margin-bottom: 20px;">Siap Bergabung Bersama Kami?</h2>
        <p style="color: #94A3B8; font-size: 1.2rem; max-width: 600px; margin: 0 auto 40px auto;">Daftarkan putra-putri Anda sekarang juga dan berikan pendidikan terbaik untuk masa depan mereka.</p>
        <a href="{{ route('ppdb.index') }}" class="btn btn-primary" style="background: var(--accent); border: none; font-size: 1.1rem; padding: 15px 40px;">
            Daftar Online Sekarang
        </a>
    </div>
</section>
@endsection
