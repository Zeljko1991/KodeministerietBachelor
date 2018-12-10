<!-- Dropdown Structure -->
<ul id="dropdown1" class="dropdown-content">
    <li><a href="/projectcase">All Cases</a></li>
    <li><a href="/projectcase/create">Create Case</a></li>
</ul>
<ul id="dropdown2" class="dropdown-content">
    <li>
        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
    </li>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</ul>
<nav>
    <div class="nav-wrapper">
        <div class="container">
            <a href="/" class="brand-logo">{{config('app.name', 'Kodeministeriet')}}</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <!-- Importing guest stuff -->
                @guest
                    <li>
                        <a href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                <!-- Register new user -->
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
                @else
                    <li><a href="/">Dashboard</a></li>
                    <!-- Dropdown Trigger -->
                    <li><a class="dropdown-trigger" href="projectcase" data-target="dropdown1">Project Cases<i class="material-icons right">arrow_drop_down</i></a></li>
                    <li><a href="/billing">Billing</a></li>
                    <li><a href="/marketing">Marketing</a></li>
                    <!-- User dropdown trigger -->
                    <li><a class="dropdown-trigger" data-target="dropdown2">{{Auth::user()->name}}<i class="material-icons right">arrow_drop_down</i></a></li>
            </ul>
        </div>
                @endguest
        </div>
    </div>
</nav>
