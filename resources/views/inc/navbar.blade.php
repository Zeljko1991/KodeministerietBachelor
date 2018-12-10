<!-- Dropdown Structure -->
<ul id="dropdown1" class="dropdown-content">
    <li><a href="/planning">All Cases</a></li>
    <li><a href="#">Create Case</a></li>
  </ul>
<nav>
    <div class="nav-wrapper">
        <div class="container">
            <a href="/" class="brand-logo">{{config('app.name', 'Kodeministeriet')}}</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="/">Dashboard</a></li>
                <li><a href="/planning">Planning</a></li>
                <!-- Dropdown Trigger -->
                <li><a class="dropdown-trigger" href="planning" data-target="dropdown1">Planning<i class="material-icons right">arrow_drop_down</i></a></li>
                <li><a href="/billing">Billing</a></li>
                <li><a href="/marketing">Marketing</a></li>
            </ul>
        </div>
    </div>
</nav>
