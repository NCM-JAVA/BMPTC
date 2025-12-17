@extends('admin.layouts.app')

@section('title', 'Edit Mobile App Content')

@section('content')
    <div class="container">

        <div class="card shadow-sm border-0 rounded-2">
            <div class="card-header dashboard-bg-color text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Add Mobile App Content</h6>
                <a href="{{ route('admin.mobile-content.index') }}" class="btn btn-light btn-sm">Back</a>
            </div>

            <div class="card-body">

                <form action="{{ route('admin.mobile-content.update',$data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3 row align-items-center">
                                <label for="page_name" class="col-sm-4 col-form-label"><b>Page Name<span
                                            style="color:red">*</span></b></label>
                                <div class="col-sm-6">
                                    <input type="text" name="page_name" id="page_name" class="form-control"
                                        value="{{ old('page_name', $data->page_name) }}" >
                                         @error('page_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="title" class="col-sm-4 col-form-label"><b>Title</b></label>
                                <div class="col-sm-6">
                                    <input type="text" name="title" id="title" class="form-control"
                                        value="{{ old('title', $data->title) }}" >
                                    @error('title')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="content" class="col-sm-4 col-form-label"><b>Content</b></label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" name="content" >{{ $data->content }}</textarea>
                                     @error('content')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="attachment" class="col-sm-4 col-form-label"><b>Attachment </b></label>
                                <div class="col-sm-6">
                                    <input type="file" name="attachment" id="attachment" class="form-control">
                                    <a href="{{ asset('public/assets/uploads/img/mobileAppContent/'.$data->attachment) }}" target="_blank">{{ $data->attachment }}</a>
                                     @error('attachment')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="status" class="col-sm-4 col-form-label"><b>Status<span
                                            style="color:red">*</span></b></label>
                                <div class="col-sm-6">
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Draft</option>
                                        <option value="2" {{ $data->status == 2 ? 'selected' : '' }}>Approval</option>
                                        <option value="3" {{ $data->status == 3 ? 'selected' : '' }}>Publish</option>
                                    </select>
                                     @error('status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
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