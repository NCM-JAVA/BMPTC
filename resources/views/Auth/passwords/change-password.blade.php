@extends('admin.layouts.app')

@section('content')
    <div class="container">

        <div class="card shadow-sm border-0 no-radius">
            <div class="card-header d-flex justify-content-between align-items-center dashboard-bg-color">
                <h6 class="mb-0">Change Password</h6>
                <a href="{{ route('admin.profile.view') }}" class="btn btn-light btn-sm">Back</a>
            </div>
            <div class="row g-3">
                <div class="col-12">
                    <div class="card shadow-sm border-0">

                        <div class="card-body">
                            <div class="row g-4">

                                <div class="col-md-12">
                                    <form method="POST" action="{{ route('admin.password.update') }}">
                                        @csrf

                                        <div class="row mb-3 align-items-center">
                                            <div class="col-md-3">
                                                <label class="form-label"><strong>Current Password <span
                                                            style="color:red">*</span></strong></label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="password" name="current_password" class="form-control">
                                                @error('current_password')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center">
                                            <div class="col-md-3">
                                                <label class="form-label"><strong>New Password <span
                                                            style="color:red">*</span></strong></label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="password" name="new_password" class="form-control">
                                                @error('new_password')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="row mb-4 align-items-center">
                                            <div class="col-md-3">
                                                <label class="form-label"><strong>Confirm New Password <span
                                                            style="color:red">*</span></strong></label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="password" name="new_password_confirmation"
                                                    class="form-control">
                                                @error('new_password_confirmation')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-8 text-center">
                                                <button type="submit" class="btn btn-success px-4">Update Password</button>
                                            </div>
                                        </div>
                                    </form>

                                    @if(session('success'))
                                        <div class="alert alert-success mt-3">{{ session('success') }}</div>
                                    @endif

                                    @if(session('error'))
                                        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection