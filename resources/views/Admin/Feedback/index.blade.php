@extends('admin.layouts.app')

@section('title', 'Manage Feedback')

@section('content')
    <div class="container">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif


        <div class="card shadow-sm border-0 no-radius">
            <div class="card-header dashboard-bg-color text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Manage Feedback</h6>

            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover custom-hover align-middle text-left">
                        <thead class="dashboard-table-heading">
                            <tr>
                                <th>#</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Contact No.</th>
                                <th>Comments</th>
                                <th>Commets Date</th>
								<th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($feedbacks as $index => $feedback)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $feedback->name }}</td>
                                    <td>{{ $feedback->email }}</td>
                                    <td>{{ $feedback->phone }}</td>
                                    <td class="text-start">{{ $feedback->comments }}</td>
                                    <td>{{ $feedback->created_at->format('d M Y') }}</td>
									<td>
										@php
											$badgeClass = $feedback->status == 0 ? 'bg-warning' : 'bg-success';
										@endphp
										<span class="badge {{ $badgeClass }}">
											{{ $feedback->status == 0 ? 'Pending' : 'Replied' }}
										</span>
									</td>
                                    <td>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#feedbackModal{{ $feedback->id }}"
                                            class="btn btn-info btn-sm" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        @if($feedback->status == 1)
                                            <button class="btn btn-secondary btn-sm disabled">
                                                <i class="bi bi-reply"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#replyModal{{ $feedback->id }}">
                                                <i class="bi bi-reply"></i>
                                            </button>
                                        @endif

                                        <form action="{{ route('admin.manage-feedback.destroy', $feedback->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Delete this feedback?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <div class="modal fade" id="feedbackModal{{ $feedback->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content shadow-lg border-0">

                                            <div class="modal-header brand-header">
                                                <h5 class="modal-title">Feedback Details</h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">

                                                <div class="row mb-3">
                                                    <div class="col-4 fw-bold text-muted">Name</div>
                                                    <div class="col-8">{{ $feedback->name }}</div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-4 fw-bold text-muted">Email</div>
                                                    <div class="col-8">{{ $feedback->email }}</div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-4 fw-bold text-muted">Phone</div>
                                                    <div class="col-8">{{ $feedback->phone }}</div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-4 fw-bold text-muted">Comments</div>
                                                    <div class="col-8">{{ $feedback->comments }}</div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-4 fw-bold text-muted">Reply</div>
                                                    <div class="col-8">{{ $feedback->reply ?? 'No reply yet' }}</div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-4 fw-bold text-muted">Status</div>
                                                    <div class="col-8">
                                                        <span
                                                            class="badge {{ $feedback->status == '1' ? 'bg-success' : 'bg-warning text-dark' }}">
                                                            {{ $feedback->status == '1' ? 'Replied' : 'Pending' }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-4 fw-bold text-muted">Replied At</div>
                                                    <div class="col-8">{{ $feedback->replied_at ?? '—' }}</div>
                                                </div>

                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-success btn-sm"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="replyModal{{ $feedback->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">

                                            <div class="modal-header brand-header">
                                                <h5 class="modal-title">Reply to {{ $feedback->name }}</h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal"></button>
                                            </div>

                                            <form action="{{ route('admin.manage-feedback.reply', $feedback->id) }}"
                                                method="POST">
                                                @csrf

                                                <div class="modal-body">

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">User Comment</label>
                                                        <div class="p-3 bg-light border rounded">
                                                            {{ $feedback->comments }}
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Your Reply</label>
                                                        <textarea name="reply" class="form-control" rows="4"
                                                            required>{{ $feedback->reply }}</textarea>
                                                    </div>

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-warning"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success">Send Reply</button>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>

                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No feedback available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $feedbacks->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection