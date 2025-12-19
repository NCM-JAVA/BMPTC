@extends('admin.layouts.app')

@section('title', 'Add Hazard')

@section('content')
    <div class="container">

        <div class="card shadow-sm border-0 rounded-2">
            <div class="card-header dashboard-bg-color text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Add Hazard</h6>
                <a href="{{ route('admin.manage-hazard.index') }}" class="btn btn-light btn-sm">Back</a>
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

                <form action="{{ route('admin.manage-hazard.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-7">
                            <div class="mb-3 row align-items-center">
                                <label for="name" class="col-sm-4 col-form-label"><b>Hazard Name<span
                                            style="color:red">*</span></b></label>
                                <div class="col-sm-6">
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name') }}" placeholder="Hazard Name" required>
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="hz_code" class="col-sm-4 col-form-label"><b>Hazard Code<span
                                            style="color:red">*</span></b></label>
                                <div class="col-sm-6">
                                    <input type="text" name="hz_code" id="hz_code" class="form-control"
                                        value="{{ old('hz_code') }}" placeholder="Hazard Code" required>
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="hz_code" class="col-sm-4 col-form-label"><b>Select State<span
                                            style="color:red">*</span></b></label>
                                <div class="col-sm-6">
                                    <select name="state" id="state" class="form-control" >
                                        <option value="">Select State</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->id }}">{{ $state->state_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                             <div class="mb-3 row align-items-center d-none" id="state_image_upload">
                                 <label for="upload_state_image" class="col-sm-4 col-form-label"><b>Upload Hazard State Image</b></label>
                                <div class="col-sm-6">
                                    <input type="file" name="upload_state_image" id="upload_state_image" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="hz_image" class="col-sm-4 col-form-label"><b>Upload Hazard India Image </b></label>
                                <div class="col-sm-6">
                                    <input type="file" name="hz_image" id="hz_image" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="hz_pdf" class="col-sm-4 col-form-label"><b>Upload PDF</b></label>
                                <div class="col-sm-6">
                                    <input type="file" name="hz_pdf" id="hz_pdf" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="status" class="col-sm-4 col-form-label"><b>Status<span
                                            style="color:red">*</span></b></label>
                                <div class="col-sm-6">
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="1" >Draft</option>
                                        <option value="2" >Approval</option>
                                        <option value="3" >Publish</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="offset-sm-4 col-sm-6">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 d-none" id="district-section">
                             <div class="">
                                <label for="districts" class="col-sm-4 col-form-label"><b>Select Districts<span
                                            style="color:red">*</span></b></label>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="select_all_districts">
                                    <label class="form-check-label" for="select_all_districts"><b>Select All</b></label>
                                </div>

                                <div class="row" id="districts-container">
                                </div>
                            </div>
                        </div>

                    </div>

                </form>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#state').change(function(){
                $('#district-section').removeClass('d-none');
                let state_id = $(this).val();
                if(state_id.length > 0){
                    $.ajax({
                        url: '{{ route("admin.get.districts") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            state_id: state_id
                        },
                        success: function(data){
                            
                            $('#districts-container').html(data);
                            // $.each(data, function(key, district){
                            //     console.log('dasdasdasd--- ', district);
                                
                            //     // $('#districts').append('<option value="'+district.id+'">'+district.district_name+'</option>');
                            //     let checkbox = `
                            //         <div class="col-md-4">
                            //             <div class="form-check">
                            //                 <input class="form-check-input district-checkbox" type="checkbox" name="districts[]" value="${district.id}" id="district_${district.id}">
                            //                 <label class="form-check-label" for="district_${district.id}">${district.district_name}</label>
                            //             </div>
                            //         </div>
                            //     `;
                            //     $('#districts-container').append(checkbox);
                            // });
                            // $('#select_all_districts').prop('checked', false);
                        }
                    });
                } else {
                    $('#districts-container').html('');
                    $('#select_all_districts').prop('checked', false);
                }

                $('#state_image_upload').removeClass('d-none');
            });

            $(document).on('change', '#select_all_districts', function(){
                $('.district-checkbox').prop('checked', $(this).prop('checked'));
            });

            $(document).on('change', '.district-checkbox', function(){
                if(!$(this).prop('checked')){
                    $('#select_all_districts').prop('checked', false);
                } else if($('.district-checkbox:checked').length === $('.district-checkbox').length){
                    $('#select_all_districts').prop('checked', true);
                }
            });

        });
        </script>

@endsection