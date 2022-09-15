<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{route('dashboard')}}"> <img alt="image" src="{{asset('assets/img/logo.png')}}" class="header-logo" /> <span
                class="logo-name">Otika</span>
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown active">
                <a href="{{route('dashboard')}}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            <li class="">
                <a href="{{route('employee.list')}}" class="nav-link"><i data-feather="user"></i><span>Employee</span></a>
            </li>
            <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>Payroll</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{route('employee.salary')}}">Set Salary</a></li>
                  <li><a class="nav-link" href="{{route('employee.payout')}}">Payout</a></li>
                </ul>
              </li>
        </ul>
    </aside>
</div>