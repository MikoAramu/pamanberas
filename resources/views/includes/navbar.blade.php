<nav
      class="navbar navbar-expand-lg navbar-light navbar-store fixed-top navbar-fixed-top"
      data-aos="fade-down"
    >
      <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
          <img src="/images/logo-paman-beras.jpg" width="120" height="65" alt="" />
        </a>
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarResponsive"
          aria-controls="navbarResponsive"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">Beranda</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('about') }}" class="nav-link">Tentang</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('contact') }}" class="nav-link">Kontak</a>
            </li>
            @guest
                <li class="nav-item">
                    <a href="{{ route('register') }}" class="nav-link">Daftar Akun</a>
                </li>
                <li class="nav-item">
                    <a
                    href="{{  route('login') }}"
                    class="btn btn-success nav-link px-4 text-white"
                    >Masuk Akun</a
                    >
                </li>
            @endguest
        </ul>

        @auth
            <!-- Desktop Menu -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('dashboard-transactions') }}" class="nav-link">Riwayat Transaksi</a>
                </li>
            </ul>
            <ul class="navbar-nav d-none d-lg-flex">
                <li class="nav-item dropdown">
                    <a
                        href="#"
                        class="nav-link"
                        id="navbarDropdown"
                        role="button"
                        data-toggle="dropdown"
                    >
                        <img
                            src="/images/user.png"
                            alt=""
                            class="rounded-circle mr-2 profile-picture"
                        />
                        Hi, {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu">
                        @if (Auth::check() && Auth::user()->roles == 'ADMIN')
                        <a href="{{ Auth::user()->roles == 'ADMIN' ? url('/admin') : route('dashboard') }}" class="dropdown-item">Dasbor</a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('dashboard-settings-account') }}" class="dropdown-item">
                            Penganturan Akun
                        </a>
                        <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                               Keluar
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                </li>
                <li class="nav-item">
                    <a href="{{ route('cart') }}" class="nav-link d-inline-block mt-2">
                        @php
                            $carts = \App\Models\Cart::where('users_id', Auth::user()->id_user)->count();
                        @endphp
                        @if($carts > 0)
                            <img src="/images/icon-cart-filled.svg" alt="" />
                            <div class="card-badge">{{ $carts }}</div>
                        @else
                            <img src="/images/icon-cart-empty.svg" alt="" />
                        @endif
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav d-block d-lg-none">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        Hi, {{ Auth::user()->name }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('cart') }}" class="nav-link d-inline-block">
                        Cart
                    </a>
                </li>
            </ul>    
        @endauth
        
    </div>
    </div>
</nav>