@extends('admin.layouts.app')

@section('title', 'Audit Trail')

@section('content')
    <div class="container">

        <div class="card shadow-sm border-0 no-radius">

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle text-left">
                        <thead class="dashboard-table-heading">
                            <tr>
                                <th width="5%">#</th>
                                <th width="10%">User Id</th>
                                <th width="10%">User Name</th>
                                <th width="20%">Old Title</th>
                                <th width="20%">Updated Title</th>
                                <th width="10%">Module</th>
                                <th width="10%">Page Action</th>
                                <th width="15%">Action date</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($audit_trails as $key => $val)
                                <tr>
                                    <td>{{ $audit_trails->firstItem() + $key }}</td>
                                    <td>{{ $val->user_id }}</td>
                                    <td>{{ $val->usertype }}</td>
                                    <td>{{ $val->old_values ?? '-' }}</td>
                                    <td>{{ $val->new_values ?? '-' }}</td>
                                    <td>{{ $val->module ?? '-' }}</td>
                                    <td>
                                        @php
                                            $event = strtolower($val->event ?? '');
                                            $badgeClass = [
                                                'insert' => 'bg-success',
                                                'update' => 'bg-primary',
                                                'delete' => 'bg-danger',
                                            ][$event] ?? 'bg-secondary';
                                        @endphp

                                        <span class="badge {{ $badgeClass }} text-uppercase fw-semibold">
                                            {{ $val->event ?? '-' }}
                                        </span>
                                    </td>

                                    <td>{{ date('d-m-Y H:i:s', strtotime($val->event_date)) ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No records found.</td>
                                </tr>
                            @endforelse
                            </tr>

                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $audit_trails->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection