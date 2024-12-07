<!-- Brand Logo -->
<a href="{{ route('admin.home') }}" class="brand-link">
    <img src="{{ asset('/assets/adminlte/dist/img/logo.jpg') }}" alt="FastForward Logo" class="brand-image elevation-3" style="opacity: .8">
    {{-- <span class="brand-text font-weight-light">QuoTech</span> --}}
</a>

<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        @can('list-dashboard')
        <li class="nav-item">
            <a href="{{ route('admin.home') }}" class="nav-link {{ request()->routeIs('admin.home') ? 'active' : '' }}">
                <i class="nav-icon far fa-image"></i>
                <p>
                    Home
                </p>
            </a>
        </li>
        @endcan

        @can('list-roles')
        <li class="nav-item">
            <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->routeIs('admin.roles*') ? 'active' : '' }}">
                <i class="nav-icon far fa-image"></i>
                <p>
                    Roles
                </p>
            </a>
        </li>
        @endcan

        @can('list-admins')
        <li class="nav-item">
            <a href="{{ route('admin.admins.index') }}" class="nav-link {{ request()->routeIs('admin.admins*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-shield"></i>
                <p>
                    Admin Users
                </p>
            </a>
        </li>
        @endcan

        @can('list-countries')
        <li class="nav-item">
            <a href="{{ route('admin.countries.index') }}" class="nav-link {{ request()->routeIs('admin.countries*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-shield"></i>
                <p>
                    Countries
                </p>
            </a>
        </li>
        @endcan

        @can('list-cities')
        <li class="nav-item">
            <a href="{{ route('admin.cities.index') }}" class="nav-link {{ request()->routeIs('admin.cities*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-shield"></i>
                <p>
                    Cities
                </p>
            </a>
        </li>
        @endcan

        @can('list-settings')
        <li class="nav-item">
            <a href="#" class="nav-link {{ (request()->routeIs('admin.settings*') || request()->routeIs('admin.announcements*') || request()->routeIs('admin.announcements*')) ? 'active' : '' }}">
                <i class="nav-icon fas fa-wrench"></i>
                <p>
                    Settings
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview" style="{{ (request()->routeIs('admin.settings*') || request()->routeIs('admin.announcements*') || request()->routeIs('admin.announcements*')) ? 'display:block' : 'display:none' }}">
                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                        <i class="nav-icon far fa-circle"></i>
                        <p>
                            General
                        </p>
                    </a>
                </li>
            </ul>
        </li>
        @endcan

    </ul>
</nav>
<!-- /.sidebar-menu -->
