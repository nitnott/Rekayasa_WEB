@extends('layouts.main')
@section('title', 'Home')
@section('content')

<div class="home">
    <div class="home-content">
        <span class="home-label">SOLUSI TEKNOLOGI INFORMASI</span>

        <h1>Technology for a Better Future</h1>

        <h2>PT Teknologi Jaya</h2>

        <p>
            Kami menyediakan solusi teknologi informasi yang inovatif,
            efisien, dan terpercaya untuk mendukung pertumbuhan bisnis
            di era digital.
        </p>

        <a href="{{ url('/profile') }}" class="button">
            Kenali Perusahaan
        </a>
    </div>

    <div class="home-features">
        <div class="feature-card">
            <div class="feature-number">01</div>
            <h3>Website Development</h3>
            <p>
                Pembuatan website profesional yang modern,
                responsif, dan sesuai kebutuhan bisnis.
            </p>
        </div>

        <div class="feature-card">
            <div class="feature-number">02</div>
            <h3>Application Development</h3>
            <p>
                Pengembangan aplikasi untuk membantu
                meningkatkan efisiensi pekerjaan.
            </p>
        </div>

        <div class="feature-card">
            <div class="feature-number">03</div>
            <h3>Database Management</h3>
            <p>
                Pengelolaan data yang terstruktur untuk
                mendukung operasional perusahaan.
            </p>
        </div>
    </div>
</div>
@endsection