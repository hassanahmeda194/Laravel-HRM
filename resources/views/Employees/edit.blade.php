@extends('Layout.master')
@section('main_section')
    {{-- @dd($user->toArray()) --}}
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $error }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endforeach
    @endif
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title fs-4 mb-3">Edit Employee</h4>
                    <hr>
                    <form action="{{ route('employee.update', ['id' => $user->id]) }}" method="POST"
                        enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <h5 class="my-3">Login Credentials</h5>
                                <hr>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="formrow-email-input" class="form-label">EMP ID</label>
                                    <input type="text" class="form-control bg-light" name="EMP_ID" readonly
                                        value="{{ $user->Emp_Id }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Your Name" name="name"
                                        value="{{ $user->name }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Email</label>
                                    <input type="text" class="form-control" placeholder="Enter Your Email" name="email"
                                        value="{{ $user->email }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Password</label>
                                    <input type="password" class="form-control" placeholder="Enter Your password"
                                        name="password" autocomplete="off" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" placeholder="Enter Your password"
                                        name="password_confirmation" autocomplete="off" >
                                </div>
                            </div>
                            <div class="col-md-4 pt-4 mt-1">
                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input class="form-check-input" type="checkbox" id="SwitchCheckSizemd" name="is_active"
                                        @checked($user->is_active == 1)>
                                    <label class="form-check-label" for="SwitchCheckSizemd">is active</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <h5 class="my-3">Employement Information</h5>
                                <hr>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Joining Date</label>
                                    <div class="input-group" id="datepicker1">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        <input type="text" class="form-control" placeholder="dd M, yyyy"
                                            data-date-format="dd M, yyyy" data-date-container='#datepicker1'
                                            data-provide="datepicker" name="joining_date" value="{{ $user->joining_date }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Salary</label>
                                    <input type="number" class="form-control" id=""
                                        placeholder="Enter Your Salery" name="salary"
                                        value="{{ $user->employement_info->salary ?? '' }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="formrow-inputState" class="form-label">Job Type</label>
                                    <select class="form-select" name="job_type" id="job_type">
                                        <option selected>Choose...</option>
                                        <op value="0" @selected($user->employement_info->job_type == 0)>Internee</option>
                                            <option value="1" @selected($user->employement_info->job_type == 1)>probation</option>
                                            <option value="2" @selected($user->employement_info->job_type == 2)>Permenant</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="formrow-inputState" class="form-label">Designation</label>
                                    <select id="formrow-inputState" class="form-select" name="designation_id">
                                        <option selected>Choose...</option>
                                        @foreach ($designations as $designation)
                                            <option value="{{ $designation->id }}" @selected($user->designation->id == $designation->id)>
                                                {{ $designation->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 row" id="leave_box">
                                <div class="col-12">
                                    <h5 class="my-3">Leave Information</h5>
                                    <hr>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Annual Leave</label>
                                        <input type="number" class="form-control" placeholder="Enter Your Annual Leave"
                                            name="annual_leave" value="{{ $user->employeeLeave->annual_leave ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Sick Leave</label>
                                        <input type="number" class="form-control" placeholder="Enter Your Casual Leave"
                                            name="sick_leave" value="{{ $user->employeeLeave->sick_leave ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Casual Leave</label>
                                        <input type="number" class="form-control" placeholder="Enter Your Casual Leave"
                                            name="casual_leave" value="{{ $user->employeeLeave->casual_leave ?? '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <h5 class="my-3">Personal Information</h5>
                                <hr>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Profile Image</label>
                                    <input type="file" class="form-control" name="profile_image">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label>Date Of Birth</label>
                                    <div class="input-group" id="datepicker1">
                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                        <input type="text" class="form-control" placeholder="dd M, yyyy"
                                            data-date-format="dd M, yyyy" data-date-container='#datepicker1'
                                            data-provide="datepicker" name="date_of_birth"
                                            value="{{ $user->employee_basic_info->date_of_birth }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">phone Number</label>
                                    <input type="tel" class="form-control" id="" placeholder="+123456789"
                                        name="phone_number" value="{{ $user->employee_basic_info->phone_number }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">personal email</label>
                                    <input type="tel" class="form-control" id=""
                                        placeholder="Enter Personal Email" name="personal_email"
                                        value="{{ $user->employee_basic_info->personal_email }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Address</label>
                                    <textarea name="" rows="4" class="form-control" name="address">{{ $user->employee_basic_info->address }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <h5 class="my-3">Account Details</h5>
                                <hr>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Account Number</label>
                                    <input type="text" class="form-control" id=""
                                        placeholder="Enter Your Account Number" name="account_number"
                                        value="{{ $user->bank_details->account_number }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Account Holder Name</label>
                                    <input type="text" class="form-control" id=""
                                        placeholder="Enter Account Holder Name" name="account_holder_name"
                                        value="{{ $user->bank_details->account_holder_name }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">IBAN</label>
                                    <input type="text" class="form-control" id=""
                                        placeholder="Enter IBAN Number" name="IBAN"
                                        value="{{ $user->bank_details->IBAN }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <h5 class="my-3">Office Timming</h5>
                                <hr>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Shift Start Time</label>
                                    <input class="form-control" type="time"
                                        value="{{ $user->employement_info->shift_start_time }}" id="example-time-input"
                                        name="shift_start_timing">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Shift End Time</label>
                                    <input class="form-control" type="time"
                                        value="{{ $user->employement_info->shift_end_time }}" id="example-time-input"
                                        name="shift_end_timing">
                                </div>
                            </div>
                            <div class="col-md-4 pt-4 mt-1">
                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input class="form-check-input" type="checkbox" id="SwitchCheckSizemd1"
                                        name="flexible_timing" @checked($user->employement_info->flexible_timing == 1)>
                                    <label class="form-check-label" for="SwitchCheckSizemd1">Flexiable Timing</label>
                                </div>
                            </div>
                            <div class="col-12 d-none">
                                <h5 class="my-3">Documents</h5>
                                <hr>
                            </div>
                            <div class="col-md-12 d-none" >
                                <div class="mb-3">
                                    <label for="" class="form-label">Documents</label>
                                    <input class="form-control" type="file" name="documents[]" multiple>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                @foreach ($user->documents as $document)
                                    <div class="card border shadow-none mb-2 py-2">
                                        <div class="d-flex align-items-center justify-content-between ">
                                            <div class="d-flex justify-content-between ">
                                                <div class="avatar-xs align-self-center me-2">
                                                    <div
                                                        class="avatar-title rounded bg-transparent text-primary font-size-20">
                                                        <i class="mdi mdi-file-document"></i>
                                                    </div>
                                                </div>
                                                <div class="overflow-hidden me-auto">
                                                    <h5 class="font-size-13 text-truncate mb-1">{{ $document->name }}
                                                    </h5>
                                                    <p class="text-muted text-truncate mb-0">21 Files</p>
                                                </div>
                                            </div>
                                            <div class="ms-2 d-flex align-items-center justify-content-between gap-1">
                                                <p>
                                                    <a href="{{ Storage::url($document->file_path) }}"
                                                        class="text-sucess btn fw-bolder" download>
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                </p>
                                                <p>
                                                    <a href="{{ route('delete.document', ['id' => $document->id]) }}"
                                                        class="text-danger btn fw-bolder">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <hr>
                        <div>
                            <button type="submit" class="btn btn-primary">Update Employee</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <script>
        $(document).ready(function() {
            $('#leave_box').hide();
            $('#job_type').change(function() {
                var jobType = $(this).val();
                $('#leave_box').toggle(jobType === '2');
            });
        });
    </script>
@endsection
