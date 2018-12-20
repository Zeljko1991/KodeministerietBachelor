<!-- Dropdown Structure -->
@guest
<div class="navbar fixed">
    <nav class="transparent z-depth-0">
        <div class="nav-wrapper">
            <div class="container">
                <a href="/" class="brand-logo">{{config('app.name', 'Kodeministeriet')}}</a>
            </div>
        </div>
    </nav>
</div>
@else
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
<ul id="dropdown3" class="dropdown-content">
    <li><a href="/customer">Customers</a></li>
    <li><a href="/billing">Billing</a></li>
</ul>
<nav>
    <div class="nav-wrapper valign-wrapper">
        <div class="container">
            <a href="/dashboard" class="brand-logo">{{config('app.name', 'Kodeministeriet')}}</a>
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
                    <li><a href="/dashboard">Dashboard</a></li>
                    <!-- Dropdown Trigger -->
                    <li><a class="dropdown-trigger" href="projectcase" data-target="dropdown1">Project Cases<i class="material-icons right">arrow_drop_down</i></a></li>
                    <li><a class="dropdown-trigger" data-target="dropdown3">Billing<i class="material-icons right">arrow_drop_down</i></a></li>
                    <li><a href="/marketing">Marketing</a></li>
                    <!-- User dropdown trigger -->
                    <li><a class="dropdown-trigger btn-floating btn-large user_badge" data-target="dropdown2" style="background-image: url('{{Auth::user()->user_img}}');"><i class="material-icons">arrow_drop_down</i></a>{{Auth::user()->name}}</li>
            </ul>
        </div>
                @endguest
        </div>
    </div>
</nav>
@endguest
