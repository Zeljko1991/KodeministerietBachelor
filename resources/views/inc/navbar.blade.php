<!-- Dropdown Structure -->
<ul id="dropdown1" class="dropdown-content">
    <li><a href="/projectcase">All Cases</a></li>
    <li><a href="/projectcase/create">Create Case</a></li>
  </ul>
<nav>
    <div class="nav-wrapper">
        <div class="container">
            <a href="/" class="brand-logo">{{config('app.name', 'Kodeministeriet')}}</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="/">Dashboard</a></li>
                <!-- Dropdown Trigger -->
                <li><a class="dropdown-trigger" href="projectcase" data-target="dropdown1">Project Cases<i class="material-icons right">arrow_drop_down</i></a></li>
                <li><a href="/billing">Billing</a></li>
                <li><a href="/marketing">Marketing</a></li>
            </ul>
        </div>
    </div>
</nav>
