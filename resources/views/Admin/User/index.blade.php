@extends('admin.layouts.app')

@section('title', 'User')

@section('content')
    <div class="container">

        <div class="card shadow-sm border-0 no-radius">
            <div class="card-header dashboard-bg-color text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">User Management</h6>
                <a href="{{ route('admin.manage-user.create') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Add New User
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle text-left table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Profile</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                               
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                             @foreach ($user as $user)
                            <tr>
                               
                                
                                <td>{{$user->id}}</td>
                                <td>
                                    <img src="{{ asset('public/assets/uploads/profile_images/' . $user->image) }}" class="rounded-circle"
                                        width="40" height="40" alt="Profile">
                                </td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    {{user_role($user->role)}}
                                </td>

                              
                              <td>
                                @if ($user->status == 1)
                               <span class="badge bg-success">Active</span>
                                   @else
                                <span class="badge bg-danger">Inactive</span>
                                    @endif
                                        </td>

                                <td>
                                    <a href="{{ route('admin.manage-user.edit', $user->id) }}" class="btn btn-sm btn-primary me-1" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                   
                                    <form action="{{ route('admin.manage-user.destroy', $user->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this user?');">
            <i class="bi bi-trash"></i>
        </button>
    </form>
                                </td>
                            </tr>

                             @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
@endsection