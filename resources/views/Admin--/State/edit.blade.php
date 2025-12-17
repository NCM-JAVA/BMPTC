@extends('admin.layouts.app')

@section('title', 'Update State')

@section('content')
    <div class="container">

        <div class="card shadow-sm border-0 rounded-2">
            <div class="card-header dashboard-bg-color text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Update State</h6>
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

                <form action="{{ route('admin.manage-state.update', $data->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3 row align-items-center">
                                <label for="name" class="col-sm-4 col-form-label"><b>State Name<span
                                            style="color:red">*</span></b></label>
                                <div class="col-sm-6">
                                    <input type="text" name="state_name" id="name" class="form-control"
                                        value="{{ old('state_name', $data->state_name) }}" required>
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
                                        value="{{ old('coordinates', $data->coordinates) }}"
                                        placeholder="e.g. 28.6139, 77.2090">
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="offset-sm-4 col-sm-6">
                                    <button type="submit" class="btn btn-success">Update State</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            @if($data->image)
                                <img src="{{ asset('public/assets/img/uploads/state/' . $data->image) }}" style="{{ !empty($data->image) ? 'cursor:pointer;' : 'cursor:default;' }}" data-bs-toggle="modal"
                                            data-bs-target="#imgModal" alt="State Image" data-image="{{ !empty($data->image) ? asset('public/assets/img/uploads/state/' . $data->image) : asset('public/assets/img/uploads/noimage.jpg') }}"
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