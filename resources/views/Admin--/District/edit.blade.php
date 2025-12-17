@extends('admin.layouts.app')

@section('title', 'Update District')

@section('content')
    <div class="container">

        <div class="card shadow-sm border-0 no-radius">
            <div class="card-header dashboard-bg-color text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Update District</h6>
                <a href="{{ route('admin.manage-district.index') }}" class="btn btn-light btn-sm">Back</a>
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

                <form action="{{ route('admin.manage-district.update', $data->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3 row align-items-center">
                                <label for="name" class="col-sm-4 col-form-label"><b>District Name<span
                                            style="color:red">*</span></b></label>
                                <div class="col-sm-5">
                                    <input type="text" name="district_name" id="name" class="form-control"
                                        value="{{ old('district_name', $data->district_name) }}" required>
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="image" class="col-sm-4 col-form-label"><b>Upload Image <span
                                            style="color:red">*</span></b></label>
                                <div class="col-sm-5">
                                    <input type="file" name="image" id="image" class="form-control">
                                    @if($data->image)
                                        <a href=" {{ asset('public/assets/uploads/img/district/' . $data->image) }}" target="_blank">{{ $data->image }}</a>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="image" class="col-sm-4 col-form-label"><b>Upload PDF <span
                                            style="color:red">*</span></b></label>
                                <div class="col-sm-5">
                                    <input type="file" name="dist_pdf" id="image" class="form-control">
                                    @if($data->dist_pdf)
                                        <a href="{{ asset('public/assets/uploads/pdf/district/' . $data->dist_pdf) }}" target="_blank">{{ $data->dist_pdf }}</a>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="coordinates" class="col-sm-4 col-form-label"><b>Coordinates <span
                                            style="color:red">*</span></b></label>
                                <div class="col-sm-5">
                                    <input type="text" name="coordinates" id="coordinates" class="form-control"
                                        value="{{ old('coordinates', $data->coordinates) }}"
                                        placeholder="e.g. 28.6139, 77.2090">
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="status" class="col-sm-4 col-form-label"><b>Status<span
                                            style="color:red">*</span></b></label>
                                <div class="col-sm-5">
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Draft</option>
                                        <option value="2" {{ $data->status == 2 ? 'selected' : '' }}>Approval</option>
                                        <option value="3" {{ $data->status == 3 ? 'selected' : '' }}>Publish</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="offset-sm-4 col-sm-5">
                                    <button type="submit" class="btn btn-success">Update State</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            @if($data->image)
                                <img src="{{ asset('public/assets/uploads/img/district/' . $data->image) }}"
                                    style="{{ !empty($data->image) ? 'cursor:pointer;' : 'cursor:default;' }}"
                                    data-bs-toggle="modal" data-bs-target="#imgModal" alt="District Image"
                                    data-image="{{ !empty($data->image) ? asset('public/assets/uploads/img/district/' . $data->image) : asset('public/assets/img/uploads/noimage.jpg') }}"
                                    width="200">
                            @endif
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <div class="modal fade" id="imgModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-body">
                    <img id="previewImg" src="" class="img-fluid rounded" alt="Image Preview">
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('click', e => {
            if (e.target.closest('[data-bs-target="#imgModal"]')) {
                document.getElementById('previewImg').src = e.target.closest('[data-bs-target="#imgModal"]').dataset.image;
            }
        });
    </script>
@endsection