<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar shadow">

    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('dashboard') }}">
                <i class="bi bi-house"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('scheduller.index') }}">
                <i class="bi bi-table"></i>
                <span>schedule</span>
            </a>
        </li>

        @if (auth()->user()->role->name == 'admin')
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('user.index') }}">
                    <i class="bi bi-person"></i>
                    <span>User</span>
                </a>
            </li>
        @endif
    </ul>

</aside><!-- End Sidebar-->
