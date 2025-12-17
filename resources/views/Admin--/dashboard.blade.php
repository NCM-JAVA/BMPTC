@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container ">

        <div class="card shadow-sm border-0 no-radius ">
            <div class="card-header dashboard-bg-color text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Mobile App Content Administration
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">

                    <div class="col-6 col-md-3 col-lg-2">
                        <div class="card text-center shadow-sm h-100 border-0 hover-scale">
                            <div class="card-body py-4">
                                <a href="#" class="card-body-icons-circle">
                                    <div class="icon-circle mb-2">
                                        <i class="bi bi-people-fill fs-2 text-primary"></i>
                                    </div>
                                    <p class="card-title mt-2">User Management</p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3 col-lg-2">
                        <div class="card text-center shadow-sm h-100 border-0 hover-scale">
                            <div class="card-body py-4">
                                <a href="#" class="card-body-icons-circle">
                                    <div class="icon-circle mb-2">
                                        <i class="bi bi-file-text-fill fs-2 text-warning"></i>
                                    </div>
                                    <p class="card-title mt-2">Manage CMS Pages</p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-6 col-md-3 col-lg-2">
                        <div class="card text-center shadow-sm h-100 border-0 hover-scale">
                            <div class="card-body py-4">
                                <a href="#" class="card-body-icons-circle">
                                    <div class="icon-circle mb-2">
                                        <i class="bi bi-globe fs-2 text-success"></i>
                                    </div>
                                    <p class="card-title mt-2">Manage Country</p>
                                </a>
                            </div>
                        </div>
                    </div> -->

                    <div class="col-6 col-md-3 col-lg-2">
                        <div class="card text-center shadow-sm h-100 border-0 hover-scale">
                            <div class="card-body py-4">
                                <a href="#" class="card-body-icons-circle">
                                    <div class="icon-circle mb-2">
                                        <i class="bi bi-flag fs-2 text-primary"></i>
                                    </div>
                                    <p class="card-title mt-2">Manage State</p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3 col-lg-2">
                        <div class="card text-center shadow-sm h-100 border-0 hover-scale">
                            <div class="card-body py-4">
                                <a href="#" class="card-body-icons-circle">
                                    <div class="icon-circle mb-2">
                                        <i class="bi bi-geo-alt fs-2 text-warning"></i>
                                    </div>
                                    <p class="card-title mt-2">Manage District</p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-6 col-md-3 col-lg-2">
                        <div class="card text-center shadow-sm h-100 border-0 hover-scale">
                            <div class="card-body py-4">
                                <a href="#" class="card-body-icons-circle">
                                    <div class="icon-circle mb-2">
                                        <i class="bi bi-building fs-2 text-success"></i>
                                    </div>
                                    <p class="card-title mt-2">Manage State Nodal Agency</p>
                                </a>
                            </div>
                        </div>
                    </div> -->

                    <div class="col-6 col-md-3 col-lg-2">
                        <div class="card text-center shadow-sm h-100 border-0 hover-scale">
                            <div class="card-body py-4">
                                <a href="#" class="card-body-icons-circle">
                                    <div class="icon-circle mb-2">
                                        <i class="bi bi-bug fs-2 text-primary"></i>
                                    </div>
                                    <p class="card-title mt-2">List of Reported Bugs</p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3 col-lg-2">
                        <div class="card text-center shadow-sm h-100 border-0 hover-scale">
                            <div class="card-body py-4">
                                <a href="#" class="card-body-icons-circle">
                                    <div class="icon-circle mb-2">
                                        <i class="bi bi-journal-text fs-2 text-success"></i>
                                    </div>
                                    <p class="card-title mt-2">Manage Audit</p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3 col-lg-2">
                        <div class="card text-center shadow-sm h-100 border-0 hover-scale">
                            <div class="card-body py-4">
                                <a href="#" class="card-body-icons-circle">
                                    <div class="icon-circle mb-2">
                                        <i class="bi bi-box-arrow-right fs-2 text-primary"></i>
                                    </div>
                                    <p class="card-title mt-2">Logout</p>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 no-radius mt-4">
            <div class="card-header dashboard-bg-color text-white">
                <h6 class="mb-0">Recent User Activity Log</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="dashboard-table-heading">
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Activity</th>
                                <th>IP Address</th>
                                <th>Logged In At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>John Doe</td>
                                <td>john@example.com</td>
                                <td>Login</td>
                                <td>192.168.1.1</td>
                                <td>2025-09-30 10:45 AM</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Jane Smith</td>
                                <td>jane@example.com</td>
                                <td>Viewed CMS Page</td>
                                <td>192.168.1.2</td>
                                <td>2025-09-30 11:05 AM</td>
                            </tr>
                            <!-- Add more rows dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection