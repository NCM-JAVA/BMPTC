@extends('admin.layouts.app')

@section('title', 'Mobile Content')

@section('content')
    <div class="container">
        <div class="card shadow-sm border-0 no-radius">
            <div class="card-header dashboard-bg-color text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Mobile App Content</h6>
                <a href="{{ route('admin.mobile-content.create') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Add New Mobile Page
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card-body">

                <div class="row mb-4">
                    <div class="col-md-6"></div>
                    <div class="col-md-6 text-end">
                        <form action="{{ route('admin.mobile-content.index') }}" method="GET" class="row g-2">
                            <div class="col-md-4">
                                <input type="text" name="search" placeholder="Search by page name or title"
                                    value="{{ request('search') }}" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>Draft</option>
                                    <option value="2" {{ request('status') == 2 ? 'selected' : '' }}>Approved</option>
                                    <option value="3" {{ request('status') == 3 ? 'selected' : '' }}>Published</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>

                            <div class="col-md-2">
                                <a href="{{ route('admin.mobile-content.index') }}"
                                    class="btn btn-secondary w-100">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle text-left">
                        <thead class="dashboard-table-heading">
                            <tr>
                                <th width="5%">#</th>
                                <th width="35%">Page Name</th>
                                <th width="10%">Title</th>
                                <th width="10%">Status</th>
                                <th width="20%">Last Updated</th>
                                <th width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($data->total() > 0)
                                @foreach($data as $key => $val)
                                    <tr>
                                        <td>{{ $data->firstItem() + $key }}</td>
                                        <td>{{ $val->page_name }}</td>
                                        <td>{{ $val->title }}</td>
                                        <td>{{ status($val->status) }}</td>
                                        <td>{{ $val->updated_at }}</td>

                                        <td>
                                            <a href="{{ route('admin.mobile-content.edit', $val->id) }}"
                                                class="btn btn-sm btn-primary me-1" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-info me-1" title="View" data-bs-toggle="modal"
                                                data-bs-target="#viewModal{{ $val->id }}">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.mobile-content.destroy', $val->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure?');" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>


                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6">
                                        No data found...
                                    </td>
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