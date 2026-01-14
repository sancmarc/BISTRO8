<header id="headerTop">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="navBar">
        <div class="container">
            <a class="navbar-brand" href="/"><img class="img-fluid" src="{{asset('img/Picture1.png')}}" alt="Bistro8 Logo" id="logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link {{ (request()->is('menu*')) ? 'active' : '' }}" href="{{route('bistro.menu')}}">Menu</a>
                    <a class="nav-link" aria-current="page" href="/#about">About</a>
                    <a class="nav-link" href="/#contact">Contact</a>


                </div>
                <!-- Right Side Of Navbar -->
                @auth
                <div class="navbar-nav ms-auto">

                    <a href="{{ url('/home') }}" class="nav-link float-end">
                        Dashboard
                    </a>

                </div>
                @endauth


            </div>

        </div>
    </nav>
</header>