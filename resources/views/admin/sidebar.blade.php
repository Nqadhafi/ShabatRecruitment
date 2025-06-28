                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Admin Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('jobs.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-light fa-briefcase"></i>
                                <p>Lowongan Pekerjaan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('exam-titles.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Manajemen Ujian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>Setting Pendidikan</p>
                                <i class="fas fa-angle-left right"></i>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.grades.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Jenjang Pendidikan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.majorities.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pilihan Jurusan</p>
                                    </a>
                                </li>

                            </ul>
                        </li>
