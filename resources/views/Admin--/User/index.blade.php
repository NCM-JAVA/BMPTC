@extends('admin.layouts.app')

@section('title', 'User')

@section('content')
    <div class="container">

        <div class="card shadow-sm border-0 no-radius">
            <div class="card-header dashboard-bg-color text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">User Management</h6>
                <a href="#" class="btn btn-light btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Add New User
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle text-left">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Joined On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                    <img src="{{ asset('public/assets/img/uploads/profile.png') }}" class="rounded-circle"
                                        width="40" height="40" alt="Profile">
                                </td>
                                <td>John Doe</td>
                                <td>john@example.com</td>
                                <td>Admin</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>12 Jan, 2024</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary me-1" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button class="btn btn-sm btn-warning me-1" title="Deactivate">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>2</td>
                                <td>
                                    <img src="{{ asset('public/assets/img/uploads/profile.png') }}" class="rounded-circle"
                                        width="40" height="40" alt="Profile">
                                </td>
                                <td>Jane Smith</td>
                                <td>jane@example.com</td>
                                <td>Editor</td>
                                <td><span class="badge bg-danger">Inactive</span></td>
                                <td>05 Feb, 2024</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary me-1" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button class="btn btn-sm btn-success me-1" title="Activate">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <tr>
                                <td>3</td>
                                <td>
                                    <img src="{{ asset('public/assets/img/uploads/profile.png') }}" class="rounded-circle"
                                        width="40" height="40" alt="Profile">
                                </td>
                                <td>Michael Johnson</td>
                                <td>michael@example.com</td>
                                <td>Viewer</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>20 Mar, 2024</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary me-1" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <button class="btn btn-sm btn-warning me-1" title="Deactivate">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
@endsection