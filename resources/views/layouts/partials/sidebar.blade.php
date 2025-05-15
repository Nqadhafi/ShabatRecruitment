<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @auth
                    @if(Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Admin Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('jobs.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-light fa-briefcase"></i>
                                <p>Job Management</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.grades.index') }}" class="nav-link">
                                <i class="nav-icon fas a-light fa-bolt"></i>
                                <p>Master Grade</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.majorities.index') }}" class="nav-link">
                                <i class="nav-icon fas a-light fa-bolt"></i>
                                <p>Master Grade</p>
                            </a>
                        </li>
                    @elseif(Auth::user()->role == 'user')
                        <li class="nav-item">
                            <a href="{{ route('applicant.dashboard') }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>Applicant Dashboard</p>
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>
        </nav>
    </div>
</aside>
