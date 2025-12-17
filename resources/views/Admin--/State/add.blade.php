@extends('admin.layouts.app')

@section('title', 'Add State')

@section('content')
    <div class="container">

        <div class="card shadow-sm border-0 rounded-2">
            <div class="card-header dashboard-bg-color text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Add State</h6>
                <a href="{{ route('admin.manage-state.index') }}" class="btn btn-light btn-sm">Back</a>
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

                <form action="{{ route('admin.manage-state.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3 row align-items-center">
                                <label for="name" class="col-sm-4 col-form-label"><b>State Name<span
                                            style="color:red">*</span></b></label>
                                <div class="col-sm-6">
                                    <input type="text" name="state_name" id="name" class="form-control"
                                        value="{{ old('state_name') }}" required>
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="name" class="col-sm-4 col-form-label"><b>State Code<span
                                            style="color:red">*</span></b></label>
                                <div class="col-sm-6">
                                    <input type="text" name="state_code" id="state_code" class="form-control"
                                        value="{{ old('state_code') }}" required>
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="status" class="col-sm-4 col-form-label"><b>Status<span
                                            style="color:red">*</span></b></label>
                                <div class="col-sm-6">
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="1" >Draft</option>
                                        <option value="2" >Approval</option>
                                        <option value="3" >Publish</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="image" class="col-sm-4 col-form-label"><b>Upload Image <span
                                            style="color:red">*</span></b></label>
                                <div class="col-sm-6">
                                    <input type="file" name="image" id="image" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="coordinates" class="col-sm-4 col-form-label"><b>Coordinates <span
                                            style="color:red">*</span></b></label>
                                <div class="col-sm-6">
                                    <input type="text" name="coordinates" id="coordinates" class="form-control"
                                        value="{{ old('coordinates') }}"
                                        placeholder="e.g. 28.6139, 77.2090">
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="offset-sm-4 col-sm-6">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </div>

                    </div>

                </form>
            </div>
        </div>

    </div>

@endsection