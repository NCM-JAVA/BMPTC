@extends('admin.layouts.app')

@section('title', 'State')

@section('content')
    <div class="container">
	
		@if(session('success'))
		<div id="success-message" class="alert alert-success alert-dismissible fade show" role="alert">
			<strong>Success!</strong> {{ session('success') }}
		</div>

		<script>
			setTimeout(function() {
				let box = document.getElementById('success-message');
				if (box) {
					box.style.transition = "opacity 1s";
					box.style.opacity = 0;
					setTimeout(() => box.remove(), 1000);
				}
			}, 5000);
		</script>
		@endif

        <div class="card shadow-sm border-0 no-radius">
            <div class="card-header dashboard-bg-color text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Manage State</h6>
                <a href="{{ route('admin.manage-state.create') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Add New State
                </a>
            </div>
			 <div class="card-header">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-end">
            <form method="GET" action="{{ route('admin.manage-state.index') }}" class="row g-2 align-items-center w-100">

                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search by state or state code"
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
                    <a href="{{ route('admin.manage-state.index') }}" class="btn btn-secondary">Reset</a>
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
                                <th width="5%">#</th>
                                <th width="15%">Name</th>
								<th width="12%">State Code</th>
								<th width="10%">State Coordinates</th>
                                <th width="10%">Image</th>
								<th width="10%">PDF</th>
								<th width="10%">Risk PDF</th>
                                <th width="10%">Status</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $key => $val)
                                <tr>
                                    <td>{{ $data->firstItem() + $key }}</td>
                                    <td>{{ $val->state_name }}</td>
									<td>{{ $val->state_code }}</td>
									<td>{!! wordwrap($val->coordinates, 45, "<br>\n", true) !!}</td>
                                    <td>
                                        @if(!empty($val->image))
                                        <img src="{{ !empty($val->image) ? asset('public/assets/img/uploads/state/' . $val->image) : asset('public/assets/img/uploads/noimage.jpg') }}"
                                            width="80" height="90" alt="Profile" style="{{ !empty($val->image) ? 'cursor:pointer;' : 'cursor:default;' }}" data-bs-toggle="modal"
                                            data-bs-target="#imgModal"
                                            data-image="{{ !empty($val->image) ? asset('public/assets/img/uploads/state/' . $val->image) : asset('public/assets/img/uploads/noimage.jpg') }}">
                                            <br><span style="color:red; font-size:12px"> (Uploaded on :  {{ \Carbon\Carbon::parse($val->image_date)->format('d M Y h:i A') }}) </span>
                                        @else
                                            <img src="{{ asset('public/assets/img/uploads/noimage.jpg') }}"
                                                    width="80" height="90"
                                                    style="cursor: default;">
                                        @endif
                                    </td>
									 <td>
										@if(!empty($val->St_pdf))
											<a href="{{ asset('public/assets/uploads/pdf/state/' . $val->St_pdf) }}" target="_blank"
											   class="btn btn-sm btn-warning me-1" title="View PDF">
											   <i class="bi bi-file-earmark-pdf-fill"></i> View
											</a>
										   
										@else
											<span class="badge bg-secondary">N/A</span>
										@endif
									</td>
									 <td>
									@if(!empty($val->risk_pdf))
											<a href="{{ asset('public/assets/uploads/pdf/state/' . $val->risk_pdf) }}" target="_blank"
											   class="btn btn-sm btn-warning me-1" title="View PDF">
											   <i class="bi bi-file-earmark-pdf-fill"></i> View
											</a>
											
										@else
											<span class="badge bg-secondary">N/A</span>
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
                                        <a href="{{ route('admin.manage-state.edit', $val->id) }}"
                                            class="btn btn-sm btn-primary me-1" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-info me-1" title="View Data"  data-bs-toggle="modal" data-bs-target="#viewModal{{ $val->id }}">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        @if($val->image)
                                            <a href="{{ $val->image ? asset('public/assets/img/uploads/state/' . $val->image) : asset('public/assets/img/uploads/noimage.jpg') }}"
                                                download class="btn btn-sm btn-success me-1" title="Download Image">
                                                <i class="bi bi-download"></i>
                                        </a>
                                        @else
                                            <a href="#" class="btn btn-sm btn-success me-1" title="Download Image" style="cursor:not-allowed">
                                                <i class="bi bi-download"></i>
                                        </a>
                                        @endif

                                    </td>
									
                                </tr>

                                <!-- View State Data -->
                                <div class="modal fade" id="viewModal{{ $val->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $val->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="viewModalLabel{{ $val->id }}">State Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="{{ $val->image ? asset('public/assets/img/uploads/state/' . $val->image) : asset('public/assets/img/uploads/noimage.jpg') }}" 
                                                class="img-fluid rounded mb-3" style="max-height: 400px;" alt="State Image">
                                            <p><strong>State Name:</strong> {{ $val->state_name }}</p>
                                            <p><strong>Status:</strong> {{ status($val->status) }}</p>
                                            <p><strong>Coordinates:</strong> {{ $val->coordinates }}</p>
                                        </div>
                                        </div>
                                    </div>
                                </div>


                            @endforeach


                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $data->links('pagination::bootstrap-5') }}
                    </div>
                </div>
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