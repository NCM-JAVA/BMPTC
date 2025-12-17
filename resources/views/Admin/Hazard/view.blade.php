@extends('admin.layouts.app')

@section('title', 'Hazard Detailss')

@section('content')
    <div class="container">

        <div class="card shadow-sm border-0 no-radius">
            <div class="card-header dashboard-bg-color text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Hazard Details</h6>
                <a href="{{ route('admin.manage-hazard.index') }}" class="btn btn-light btn-sm">Back</a>
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <span><strong>Hazard Name:</strong> {{ $hazard->name }} </span>
                    </div>
                    <div class="col-md-4">
                        <span><strong>Hazard Code:</strong> {{ $hazard->hz_code }} </span>
                    </div>
                    <div class="col-md-4">
                        <span><strong>Status:</strong> {{ status($hazard->status) }} </span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        @foreach ($hazard_states as $val)
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-2">
                                        <span><strong style="color:#89b827">{{ $val->state_name }}</strong>:</span>
                                    </div>
                                    <div class="col-md-10">
                                        @if (!empty($hazard_districts[$val->state_id]) && count($hazard_districts[$val->state_id]) > 0)
                                            @foreach ($hazard_districts[$val->state_id] as $district)
                                                <span class="badge bg-bmtpc mb-1">{{ $district->district_name }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                
                               
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection