<header class="site-header">
    <div class="navbar">
        <a href="{{ url('/home') }}" class="brand">
            <div class="brand-icon">TJ</div>
            <div class="brand-text">
                <span class="brand-name">PT TEKNOLOGI JAYA</span>
                <span class="brand-subtitle">Information Technology Solutions</span>
            </div>
        </a>

        <nav class="nav-menu">
            <a href="{{ url('/home') }}" class="{{ request()->is('home') ? 'active' : '' }}">Home</a>
            <a href="{{ url('/profile') }}" class="{{ request()->is('profile') ? 'active' : '' }}">Profile</a>
            <a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'active' : '' }}">About</a>
            <a href="{{ url('/service') }}" class="{{ request()->is('service') ? 'active' : '' }}">Service</a>
            <a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">Contact</a>
            <a href="{{ url('/mahasiswa') }}" class="{{ request()->is('mahasiswa*') ? 'active' : '' }}">Mahasiswa</a>
        </nav>
    </div>
</header>
