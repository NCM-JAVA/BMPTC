<nav class="navbar navbar-expand-lg admin-navbar shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-white" href="{{ route('admin.index') }}">
            <img src="{{ asset('public/assets/img/logo.png') }}" style="width:100px; height:50px" />
            Building Materials & Technology Promotion Council (BMTPC)
        </a>

        <div class="ms-auto d-flex align-items-center gap-3">

            <div class="d-flex gap-3">
                <div class="d-flex align-items-center gap-2 p-2 text-white shadow rounded"
                    style="background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);">
                    <div class="d-flex align-items-center justify-content-center bg-white text-primary rounded-circle"
                        style="width:30px; height:30px;">
                        <i class="bi bi-calendar-event fs-5"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-6">Today</div>
                        <div class="fs-6">{{ now()->format('d, M Y') }}</div>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2 p-2 text-white shadow rounded"
                    style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                    <div class="d-flex align-items-center justify-content-center bg-white text-success rounded-circle"
                        style="width:30px; height:30px;">
                        <i class="bi bi-clock fs-5"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-6">Current Time</div>
                        <div class="fs-6">{{ now()->format('h:i A') }}</div>
                    </div>
                </div>
            </div>


            <div class="dropdown">
                <a class="nav-link dropdown-toggle text-white fw-semibold" href="#" role="button"
                    data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle me-1"></i> Admin
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <i class="bi bi-pencil-square me-2 text-primary"></i> Edit Profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.password.change') }}">
                            <i class="bi bi-key me-2 text-warning"></i> Change Password
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </a>
                        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">@csrf</form>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</nav>