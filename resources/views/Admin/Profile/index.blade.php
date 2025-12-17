@extends('admin.layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="container">

        <div class="card shadow-sm border-0 no-radius">
            <div class="card-header d-flex justify-content-between align-items-center dashboard-bg-color">
                <h6 class="mb-0">User Profile</h6>
                <div>
                    <a href="#" class="btn btn-light btn-sm me-2">
                        <i class="bi bi-pencil-square me-1"></i>Edit Profile
                    </a>
                    <a href="{{ route('admin.password.change') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-key me-1"></i>Change Password
                    </a>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-12">
                    <div class="card shadow-sm border-0"> 

                        <div class="card-body">
                            <div class="row g-4">

                                <div class="col-md-4 text-center">
                                    <img src="{{ asset('public/assets/img/uploads/profile.png') }}"
                                        alt="Profile Picture" class="profile-img mb-3">
                                    <div>
                                        <button class="btn btn-success btn-sm"><i
                                                class="bi bi-upload me-1"></i>Upload</button>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <h4 class="mb-3">{{ auth()->user()->name }}</h4>
                                    <p><i class="bi bi-envelope me-2"></i>{{ auth()->user()->email }}</p>
                                    <p><i class="bi bi-telephone me-2"></i>{{ auth()->user()->phone ?? 'N/A' }}</p>
                                    <p><i class="bi bi-geo-alt me-2"></i>{{ auth()->user()->location ?? 'N/A' }}</p>

                                    <hr>

                                    <h6>Additional Info</h6>
                                    <table class="table table-borderless mb-0">
                                        <tr>
                                            <th>Role:</th>
                                            <td>{{ auth()->user()->role ? 'Admin' : 'User' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Joined:</th>
                                            <td>{{ auth()->user()->created_at->format('d M, Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status:</th>
                                            <td>
                                                @if(auth()->user()->status)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection