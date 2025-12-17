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
                                <a href="{{ route('admin.manage-user.index') }}" class="card-body-icons-circle">
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
                                <a href="{{ route('admin.mobile-content.index') }}" class="card-body-icons-circle">
                                    <div class="icon-circle mb-2">
                                        <i class="bi bi-phone-fill fs-2 text-warning"></i>
                                    </div>
                                    <p class="card-title mt-2">Manage Mobile App Content</p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3 col-lg-2">
                        <div class="card text-center shadow-sm h-100 border-0 hover-scale">
                            <div class="card-body py-4">
                                <a href="{{ route('admin.manage-hazard.index') }}" class="card-body-icons-circle">
                                    <div class="icon-circle mb-2">
                                        <i class="bi bi-exclamation-triangle-fill fs-2 text-success"></i>
                                    </div>
                                    <p class="card-title mt-2">Manage Hazard</p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3 col-lg-2">
                        <div class="card text-center shadow-sm h-100 border-0 hover-scale">
                            <div class="card-body py-4">
                                <a href="{{ route('admin.manage-state.index') }}" class="card-body-icons-circle">
                                    <div class="icon-circle mb-2">
                                        <i class="bi bi-geo-alt-fill fs-2 text-primary"></i>
                                    </div>
                                    <p class="card-title mt-2">Manage State</p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3 col-lg-2">
                        <div class="card text-center shadow-sm h-100 border-0 hover-scale">
                            <div class="card-body py-4">
                                <a href="{{ route('admin.manage-district.index') }}" class="card-body-icons-circle">
                                    <div class="icon-circle mb-2">
                                        <i class="bi bi-map-fill fs-2 text-warning"></i>
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
                                <a href="{{ route('admin.manage-feedback.index') }}" class="card-body-icons-circle">
                                    <div class="icon-circle mb-2">
                                        <i class="bi bi-chat-dots-fill fs-2 text-primary"></i>
                                    </div>
                                    <p class="card-title mt-2">Manage Feedback</p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-3 col-lg-2">
                        <div class="card text-center shadow-sm h-100 border-0 hover-scale">
                            <div class="card-body py-4">
                                <a href="{{ route('admin.audit-trails.index') }}" class="card-body-icons-circle">
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
                                <a href="{{ route('logout') }}" class="card-body-icons-circle"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <div class="icon-circle mb-2">
                                        <i class="bi bi-box-arrow-right fs-2 text-primary"></i>
                                    </div>
                                    <p class="card-title mt-2">Logout</p>
                                </a>
                                <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">@csrf
                                </form>
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
                                <th>Title </th>
                                <th>Module</th>
                                <th>Page Action</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $key => $val)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $val->usertype }}</td>
                                    <td>{{ $val->new_values }}</td>
                                    <td>{{ $val->module }}</td>
                                    <td>
                                        @php
                                            $event = strtolower($val->event ?? '');
                                            $badgeClass = [
                                                'insert' => 'bg-success',
                                                'update' => 'bg-primary',
                                                'delete' => 'bg-danger',
                                            ][$event] ?? 'bg-secondary';
                                        @endphp

                                        <span class="badge {{ $badgeClass }} text-uppercase fw-semibold">
                                            {{ $val->event ?? '-' }}
                                        </span>
                                    </td>
                                    <td>{{ date('d-m-Y H:i:s', strtotime($val->event_date)) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No records found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection