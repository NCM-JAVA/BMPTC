@extends('admin.layouts.app')

@section('title', 'Update District')

@section('content')
    <div class="container">
	
		@if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="successAlert">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('info'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert" id="successAlert">
                <strong>Error!</strong> {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif	

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
                        <div class="col-md-12">
                            <div class="mb-3 row align-items-center">
                                <label for="name" class="col-sm-2 col-form-label"><b>District Name<span
                                            style="color:red">*</span></b></label>
                                <div class="col-sm-4">
                                    <input type="text" name="district_name" id="name" class="form-control"
                                        value="{{ old('district_name', $data->district_name) }}" required>
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="image" class="col-sm-2 col-form-label"><b>Upload Image </b></label>
                                <div class="col-sm-4">
                                    <input type="file" name="image" id="image" class="form-control">
                                    @if($data->image)
										<div class="mt-3">
											<a href=" {{ asset('public/assets/uploads/img/district/' . $data->image) }}"
												target="_blank">{{ $data->image }}</a>
												
											<a href="{{ route('admin.file.delete', [
													'model' => 'District',
													'id' => $data->id,
													'column' => 'image',
													'path' => 'assets/uploads/img/district/'
												]) }}" class="btn btn-danger btn-sm"
												onclick="return confirm('Are you sure you want to delete this file?');">
												<i class="bi bi-trash"></i>
											</a>
										</div>
                                    @endif
                                    <!-- @if($data->image)
                                            <img src="{{ asset('public/assets/uploads/img/district/' . $data->image) }}"
                                                style="{{ !empty($data->image) ? 'cursor:pointer;' : 'cursor:default;' }}"
                                                data-bs-toggle="modal" data-bs-target="#imgModal" alt="District Image"
                                                data-image="{{ !empty($data->image) ? asset('public/assets/uploads/img/district/' . $data->image) : asset('public/assets/img/uploads/noimage.jpg') }}"
                                                width="200">
                                        @endif -->
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="image" class="col-sm-2 col-form-label"><b>Upload PDF </b></label>
                                <div class="col-sm-4">
                                    <input type="file" name="dist_pdf" id="image" class="form-control">
                                    @if($data->dist_pdf)
										<div class="mt-3">
											<a href="{{ asset('public/assets/uploads/pdf/district/' . $data->dist_pdf) }}"
												target="_blank">{{ $data->dist_pdf }}</a>
												
											<a href="{{ route('admin.file.delete', [
													'model' => 'District',
													'id' => $data->id,
													'column' => 'dist_pdf',
													'path' => 'assets/uploads/pdf/district/'
												]) }}" class="btn btn-danger btn-sm"
												onclick="return confirm('Are you sure you want to delete this file?');">
												<i class="bi bi-trash"></i>
											</a>
										</div>
                                    @endif
                                </div>
                            </div>
							 <div class="mb-3 row align-items-center">
                                <label for="image" class="col-sm-2 col-form-label"><b>Risk Upload PDF </b></label>
                                <div class="col-sm-4">
                                    <input type="file" name="risk_pdf" id="image" class="form-control">
                                    @if($data->risk_pdf)
                                        <a href="{{ asset('public/assets/uploads/pdf/district/' . $data->risk_pdf) }}"
                                            target="_blank">{{ $data->risk_pdf }}</a>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="coordinates" class="col-sm-2 col-form-label"><b>Coordinates </b></label>
											
								<div class="col-sm-4">
                                    <input type="text" class="form-control" name="coordinates" id="coordinates" value="{{ old('coordinates', $data->coordinates) }}" placeholder="e.g. 28.6139, 77.2090">
                                </div>

									{{-- <div class="col-sm-10">
                                    <div class="table-responsive">
                                        <table
                                            class="table table-striped table-bordered align-middle text-left table-hover mb-0">
                                            <thead class="dashboard-table-heading">
                                                <tr>
                                                    <th>Zone Name</th>
                                                    <th>Zone Co-ordinates</th>
                                                    <th>Image Map Shape</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($hazard_zone as $val)
                                                    @php
                                                        //$coordData = $val->coordinates->firstWhere('zone_id', $val->zone_id);
                                                        $coord = $coords_data->get($val->zone_id);
                                                    @endphp
                                                    <tr>
                                                        <th>
                                                            {{ $val->zone_name }}
                                                            <input type="hidden" name="zone_id[]" value="{{ $val->zone_id }}" />
                                                        </th>
                                                        <td><input type="text" class="form-control" name="zone_coordinates[]"
                                                                value="{{ old('zone_coordinates.' . $loop->index, $coord->zone_coordinates ?? '') }}" /></td>
                                                        <td>
                                                            <select name="mapshapeid[]" class="form-select">
                                                                @foreach ($map_shape as $shape)
                                                                    <option value="{{ $shape->shape_id }}"
                                                                    {{ isset($coord) && $coord->zonemapshape == $shape->shape_id ? 'selected' : '' }}>
                                                                    {{ $shape->shape }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div> --}}
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="status" class="col-sm-2 col-form-label"><b>Status<span
                                            style="color:red">*</span></b></label>
                                <div class="col-sm-4">
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Draft</option>
                                        <option value="2" {{ $data->status == 2 ? 'selected' : '' }}>Approval</option>
                                        <option value="3" {{ $data->status == 3 ? 'selected' : '' }}>Publish</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="offset-sm-2 col-sm-5">
                                    <button type="submit" class="btn btn-success">Update District</button>
                                </div>
                            </div>
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