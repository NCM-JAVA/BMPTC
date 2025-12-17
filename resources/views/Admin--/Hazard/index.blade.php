@extends('admin.layouts.app')

@section('title', 'Manage Hazard')

@section('content')
    <div class="container">

        <div class="card shadow-sm border-0 no-radius">
            <div class="card-header dashboard-bg-color text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Manage Hazard</h6>
                <a href="{{ route('admin.manage-hazard.create') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Add New Hazard
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle text-left">
                        <thead class="dashboard-table-heading">
                            <tr>
                                <th>#</th>
                                <th>Hazard Name</th>
                                <th>Hazard Code</th>
                                <th>Attachment</th>
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
                                        <td>{{ status($val->status) }}</td>
                                        <td>
                                            <a href="{{ route('admin.manage-hazard.edit', $val->id) }}"
                                                class="btn btn-sm btn-primary me-1" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                             <a href="{{ route('admin.manage-hazard.show', $val->id) }}"
                                                class="btn btn-sm btn-primary me-1" title="Edit">
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