<header style="background-color: #ff4d4d; padding: 10px;">
    <!-- Logo -->
    <a href="/" style="text-decoration: none; font-size: 24px; font-weight: bold; color: white;">
        Eventify
    </a>

    <!-- Navegación -->
    <nav class="navbar navbar-expand-lg">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon" style="color: white;"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav mr-auto">
                <!-- Si hay más enlaces aquí -->
            </div>

            <div class="navbar-nav d-flex align-items-center ml-auto">
                @guest
                    <!-- Login -->
                    <a class="nav-link text-white" href="{{ route('login') }}" style="font-size: 18px; margin-right: 15px;">Login</a>

                    <!-- Register -->
                    <a class="nav-link text-white" href="{{ route('register') }}" style="font-size: 18px; margin-right: 15px;">Register</a>
                @else
                    <!-- Logout -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a class="nav-link text-white" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="font-size: 18px; margin-right: 15px;">Logout</a>
                @endguest

                <!-- Tus eventos -->
                <a href="{{ route('myevents') }}" class="nav-link text-white" style="font-size: 18px; margin-right: 15px;">Tus eventos</a>

                <!-- Icono de usuario -->
                @if(Auth::check() && Auth::user()->profile_picture) <!-- Verifica si el usuario tiene una foto de perfil -->
                <a href="{{ route('profile') }}" class="nav-link d-flex align-items-center" style="margin-left: 10px;">
                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="User " style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid white;">
                </a>
                @else
                    <a href="{{ route('profile') }}" class="nav-link d-flex align-items-center" style="margin-left: 10px;">
                        <img src="{{ asset('assets/img/default-profile.png') }}" alt="User " style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid white;">
                    </a>
                @endif
            </div>
        </div>
    </nav>
</header>
