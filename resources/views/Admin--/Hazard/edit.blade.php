@extends('admin.layouts.app')

@section('title', 'Update Hazard')

@section('content')
    <div class="container">

        <div class="card shadow-sm border-0 rounded-2">
            <div class="card-header dashboard-bg-color text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Update Hazard</h6>
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
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                <form action="{{ route('admin.manage-hazard.update', $data->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-7">
                            <div class="mb-3 row align-items-center">
                                <label for="name" class="col-sm-4 col-form-label"><b>Hazard Name<span
                                            style="color:red">*</span></b></label>
                                <div class="col-sm-6">
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name', $data->name) }}" >
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="hz_code" class="col-sm-4 col-form-label"><b>Select State<span
                                            style="color:red">*</span></b></label>
                                <div class="col-sm-6">
                                    <select name="state" id="state" class="form-control" >
                                        <option value="">Select State</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->id }}" >{{ $state->state_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="hz_image" class="col-sm-4 col-form-label"><b>Upload Image </b></label>
                                <div class="col-sm-6">
                                    <input type="file" name="hz_image" id="hz_image" class="form-control">
                                    @if($data->hz_image)
                                        <a href="{{ asset('public/assets/uploads/img/hazards/'.$data->hz_image) }}" target="_blank">{{ $data->hz_image }}</a>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row align-items-center">
                                <label for="image" class="col-sm-4 col-form-label"><b>Upload PDF </b></label>
                                <div class="col-sm-6">
                                    <input type="file" name="hz_pdf" id="hz_pdf" class="form-control">
                                    @if($data->hz_image)
                                        <a href="{{ asset('public/assets/uploads/pdf/hazards/'.$data->hz_pdf) }}" target="_blank">{{ $data->hz_pdf }}</a>
                                    @endif
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

                            <div class="row mt-4">
                                <div class="offset-sm-4 col-sm-6">
                                    <button type="submit" class="btn btn-success">Update Hazard</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 d-none" id="district-section">
                            <!-- @if($data->hz_image)
                                <img src="{{ asset('public/assets/uploads/img/hazards/' . $data->hz_image) }}" style="{{ !empty($data->hz_image) ? 'cursor:pointer;' : 'cursor:default;' }}" data-bs-toggle="modal"
                                            data-bs-target="#imgModal" alt="Hazards Image" data-image="{{ !empty($data->hz_image) ? asset('public/assets/uploads/img/hazards/' . $data->hz_image) : asset('public/assets/img/uploads/noimage.jpg') }}"
                                    width="200">
                            @endif -->
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

    <div class="modal fade" id="imgModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-body">
                    <img id="previewImg" src="" class="img-fluid rounded" alt="Image Preview">
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('click', e => {
            if (e.target.closest('[data-bs-target="#imgModal"]')) {
                document.getElementById('previewImg').src = e.target.closest('[data-bs-target="#imgModal"]').dataset.image;
            }
        });
    </script>

    <script>
        $(document).ready(function(){
            $('#state').change(function(){
                $('#district-section').removeClass('d-none');
                let state_id = $(this).val();
                var hazard_id = {{ $data->id ?? 0 }};
                if(state_id.length > 0){
                    $.ajax({
                        url: '{{ route("admin.get.districts") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            state_id: state_id,
                            hazard_id: hazard_id
                        },
                        success: function(data){
                            $('#districts-container').html(data);

                            // $('#districts-container').html('');
                            // $.each(data, function(key, district){
                            //     console.log(district);
                                
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