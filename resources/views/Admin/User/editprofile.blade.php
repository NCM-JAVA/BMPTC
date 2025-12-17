@extends('admin.layouts.app')

@section('title', 'Update Profile')

@section('content')
<div class="container">

    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header dashboard-bg-color text-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Update Profile</h6>
            <a href="{{ url()->previous() }}" class="btn btn-light btn-sm">Back</a>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.updateprofile', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    {{-- Left side: form fields --}}
                    <div class="col-md-6">

                        {{-- Name --}}
                        <div class="mb-3 row align-items-center">
                            <label for="name" class="col-sm-4 col-form-label"><b>Name <span class="text-danger">*</span></b></label>
                            <div class="col-sm-8">
                                <input type="text" name="name" id="name" class="form-control"
                                       value="{{ old('name', $user->name) }}" required>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3 row align-items-center">
                            <label for="email" class="col-sm-4 col-form-label"><b>Email <span class="text-danger">*</span></b></label>
                            <div class="col-sm-8">
                                <input type="email" name="email" id="email" class="form-control"
                                       value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        {{-- Role --}}
                        <div class="mb-3 row align-items-center">
                            <label for="role" class="col-sm-4 col-form-label"><b>Role <span class="text-danger">*</span></b></label>
                            <div class="col-sm-8">
                                <select name="role" id="role" class="form-select" required>
                                    <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Admin</option>
                                    <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>User</option>
                                </select>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="mb-3 row align-items-center">
                            <label for="status" class="col-sm-4 col-form-label"><b>Status <span class="text-danger">*</span></b></label>
                            <div class="col-sm-8">
                                <select name="status" id="status" class="form-select" required>
                                    <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        {{-- Profile Image upload --}}
                        <div class="mb-3 row align-items-center">
                            <label for="image" class="col-sm-4 col-form-label"><b>Profile Image</b></label>
                            <div class="col-sm-8">
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            </div>
                        </div>

                        {{-- Submit button --}}
                        <div class="row mt-4">
                            <div class="offset-sm-4 col-sm-8">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </div>

                    </div>

                    {{-- Right side: display image --}}
                    <div class="col-md-6 d-flex justify-content-center align-items-start">
                        @if ($user->image)
                            <img src="{{ asset('public/assets/uploads/profile_images/' . $user->image) }}"  
                                 alt="Profile Image" class="rounded img-fluid" style="max-height: 200px;">
                        @else
                            <p class="text-muted">No image uploaded</p>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
