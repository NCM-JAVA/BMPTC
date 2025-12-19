@extends('admin.layouts.app')

@section('title', 'Manage Hazard')

@section('content')
    <div class="container">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="flash-success">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="flash-error">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0 no-radius">
            <div class="card-header dashboard-bg-color text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Manage Hazard</h6>
                <a href="{{ route('admin.manage-hazard.create') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Add New Hazard
                </a>
            </div>
			 <div class="card-header">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-end">
                        <form method="GET" action="{{ route('admin.manage-hazard.index') }}" class="row g-2 align-items-center w-100">

                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="Search by hazard or hazard code"
                                    value="{{ request('search') }}">
                            </div>
                            
                            <div class="col-md-3">
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Draft</option>
                                    <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Approved</option>
                                    <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Published</option>
                                </select>
                            </div>

                            <div class="col-md-4 d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <a href="{{ route('admin.manage-hazard.index') }}" class="btn btn-secondary">Reset</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle text-left table-hover mb-0">
                        <thead class="dashboard-table-heading">
                            <tr>
                                <th>#</th>
                                <th>Hazard Name</th>
                                <th>Hazard Code</th>
                                <th>Attachment</th>
								<th>PDF</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($data) && $data->count() > 0)
                                @foreach($data as $key => $val)
                                    <tr>
                                        <td>{{ $data->firstItem() + $key }}</td>
                                        <td>{{ $val->name }}</td>
                                        <td>{{ $val->hz_code }}</td>
                                        <td>
                                            @if(!empty($val->hz_image))
                                                <img src="{{ !empty($val->hz_image) ? asset('public/assets/uploads/img/hazards/' . $val->hz_image) : asset('public/assets/img/uploads/noimage.jpg') }}"
                                                    width="80" height="90" alt="Profile"
                                                    style="{{ !empty($val->hz_image) ? 'cursor:pointer;' : 'cursor:default;' }}"
                                                    data-bs-toggle="modal" data-bs-target="#imgModal"
                                                    data-image="{{ !empty($val->hz_image) ? asset('public/assets/uploads/img/hazards/' . $val->hz_image) : asset('public/assets/img/uploads/noimage.jpg') }}">
                                            @else
                                                <img src="{{ asset('public/assets/img/uploads/noimage.jpg') }}" width="80" height="90"
                                                    style="cursor: default;">
                                            @endif
                                        </td>
										 <td>
                                             @if(!empty($val->hz_pdf))
                                            <a href="{{ asset('public/assets/uploads/pdf/hazards/' . $val->hz_pdf) }}" target="_blank" class="btn btn-sm btn-warning">
                                             <i class="bi bi-file-earmark-pdf-fill"></i> View PDF
                                                     </a>
                                                 @else
                                            <span class="text-muted">No PDF uploaded</span>
                                                 @endif
                                                  </td>
                                        <td>
											@php
												$badgeClass = $val->status == 1 ? 'bg-danger' : ($val->status == 2 ? 'bg-warning' : 'bg-success');
											@endphp
											<span class="badge {{ $badgeClass }}">
											{{ status($val->status) }}
											</span>
										</td>
                                        <td>
                                            <a href="{{ route('admin.manage-hazard.edit', $val->id) }}"
                                                class="btn btn-sm btn-primary me-1" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                             <a href="{{ route('admin.manage-hazard.show', $val->id) }}"
                                                class="btn btn-sm btn-info me-1" title="Edit">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <!-- <a href="#" class="btn btn-sm btn-info me-1" title="View Data" data-bs-toggle="modal"
                                                data-bs-target="#viewModal{{ $val->id }}">
                                                <i class="bi bi-eye"></i>
                                            </a> -->

                                            <!-- @if($val->hz_image)
                                                <a href="{{ $val->hz_image ? asset('public/assets/uploads/img/hazards/' . $val->hz_image) : asset('public/assets/img/uploads/noimage.jpg') }}"
                                                    download class="btn btn-sm btn-success me-1" title="Download Image">
                                                    <i class="bi bi-download"></i>
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-sm btn-success me-1" title="Download Image"
                                                    style="cursor:not-allowed">
                                                    <i class="bi bi-download"></i>
                                                </a>
                                            @endif -->

                                        </td>
                                    </tr>

                                    <div class="modal fade" id="viewModal{{ $val->id }}" tabindex="-1"
                                        aria-labelledby="viewModalLabel{{ $val->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="viewModalLabel{{ $val->id }}">Hazard Details</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <p><strong>Hazrad Name:</strong> {{ $val->name }}</p>
                                                    <p><strong>Hazard Code:</strong> {{ $val->hz_code }}</p>
                                                    <p><strong>Status:</strong> {{ status($val->status) }}</p>
                                                    <img src="{{ $val->hz_image ? asset('public/assets/uploads/img/hazards/' . $val->hz_image) : asset('public/assets/img/uploads/noimage.jpg') }}"
                                                        class="img-fluid rounded mb-3" style="max-height: 400px;"
                                                        alt="Hazard Image">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7">No data found...</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $data->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection