<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="{{ route('admin.profile.show') }}" class="d-block">{{ Auth::user()->name }}</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
            data-accordion="false">

            @if(Auth::user()->is_admin == 1)
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        {{ __('Dashboard') }}
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        {{ __('Users') }}
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.bookings.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-book"></i>
                    <p>
                        {{ __('Booking') }}
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.travel_packages.index') }}" class="nav-link">
                    <i class="nav-icon fa fa-hotel"></i>
                    <p>
                        {{ __('Travel Package') }}
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.tickets.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-ticket-alt"></i>
                    <p>
                        {{ __('Tickets') }}
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-circle nav-icon"></i>
                    <p>
                        Blog
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    <li class="nav-item">
                        <a href="{{ route('admin.categories.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Category</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.blogs.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Add Blog</p>
                        </a>
                    </li>
                </ul>
            </li>
            @elseif(Auth::user()->is_admin == 2)
            <li class="nav-item">
                <a href="{{ route('admin.bookings.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-book"></i>
                    <p>
                        {{ __('Booking') }}
                    </p>
                </a>
            <li class="nav-item">
                <a href="{{ route('homepage') }}" class="nav-link">
                    <i class="nav-icon fas fa-globe"></i>
                    <p>
                        {{ __('Branda') }}
                    </p>
                </a>
            </li>

            </li>
            @elseif(Auth::user()->is_admin == 3)
            <li class="nav-item">
                <a href="{{ route('admin.bookings.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-book"></i>
                    <p>
                        {{ __('Booking') }}
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.loket.cekin') }}" class="nav-link">
                    <i class="nav-icon fas fa-ticket-alt"></i>
                    <p>
                        {{ __('Cekin') }}
                    </p>
                </a>
            </li>
            @endif
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->