@extends('Layout.master')
@section('main_section')
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
                    <h4 class="card-title fs-4 mb-3">Add New Employee</h4>
                    <hr>
                    <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data">
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
                                        value="{{ $Emp_ID }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Your Name" name="name"
                                        value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Email</label>
                                    <input type="text" class="form-control" placeholder="Enter Your Email" name="email"
                                        value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Password</label>
                                    <input type="password" class="form-control" placeholder="Enter Your password"
                                        name="password">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" placeholder="Enter Your password"
                                        name="password_confirmation">
                                </div>
                            </div>
                            <div class="col-md-4 pt-4 mt-1">
                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input class="form-check-input" type="checkbox" id="SwitchCheckSizemd" name="is_active"
                                        checked>
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
                                            data-provide="datepicker" name="joining_date" value="{{ old('joining_date') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Salary</label>
                                    <input type="number" class="form-control" id=""
                                        placeholder="Enter Your Salery" name="salary" value="{{ old('salary') }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="formrow-inputState" class="form-label">Job Type</label>
                                    <select class="form-select" name="job_type" id="job_type">
                                        <option selected>Choose...</option>
                                        <option value="0">Internee</option>
                                        <option value="1">probation</option>
                                        <option value="2">Permenant</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="formrow-inputState" class="form-label">Designation</label>
                                    <select id="formrow-inputState" class="form-select" name="designation_id">
                                        <option selected>Choose...</option>
                                        @foreach ($designations as $designation)
                                            <option value="{{ $designation->id }}">{{ $designation->name }}</option>
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
                                            name="annual_leave" value="{{ old('annual_leave') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Sick Leave</label>
                                        <input type="number" class="form-control" placeholder="Enter Your Casual Leave"
                                            name="sick_leave" value="{{ old('sick_leave') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Casual Leave</label>
                                        <input type="number" class="form-control" placeholder="Enter Your Casual Leave"
                                            name="casual_leave" value="{{ old('casual_leave') }}">
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
                                            value="{{ old('date_of_birth') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">phone Number</label>
                                    <input type="tel" class="form-control" id="" placeholder="+123456789"
                                        name="phone_number" value="{{ old('phone_number') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">personal email</label>
                                    <input type="tel" class="form-control" id=""
                                        placeholder="Enter Personal Email" name="personal_email"
                                        value="{{ old('personal_email') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">CNIC</label>
                                    <input type="text" class="form-control" id=""
                                        placeholder="Enter CNIC number" name="cnic" value="{{ old('cnic') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Address</label>
                                    <textarea rows="4" class="form-control" name="address">{{ old('address') }}</textarea>
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
                                        value="{{ old('account_number') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Account Holder Name</label>
                                    <input type="text" class="form-control" id=""
                                        placeholder="Enter Account Holder Name" name="account_holder_name"
                                        value="{{ old('account_holder_name') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">IBAN</label>
                                    <input type="text" class="form-control" id=""
                                        placeholder="Enter IBAN Number" name="IBAN" value="{{ old('IBAN') }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <h5 class="my-3">Office Timming</h5>
                                <hr>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Shift Start Time</label>
                                    <input class="form-control" type="time" value="09:00" id="example-time-input"
                                        name="shift_start_timing">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">Shift End Time</label>
                                    <input class="form-control" type="time" value="05:00" id="example-time-input"
                                        name="shift_end_timing">
                                </div>
                            </div>
                            <div class="col-md-4 pt-4 mt-1">
                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                    <input class="form-check-input" type="checkbox" id="SwitchCheckSizemd1"
                                        name="flexible_timing">
                                    <label class="form-check-label" for="SwitchCheckSizemd1">Flexiable Timing</label>
                                </div>
                            </div>
                            <div class="col-12 d-none">
                                <h5 class="my-3">Documents</h5>
                                <hr>
                            </div>
                            <div class="col-md-12 d-none">
                                <div class="mb-3">
                                    <label for="" class="form-label">Documents</label>
                                    <input class="form-control" type="file" name="documents[]" multiple>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div>
                            <button type="submit" class="btn btn-primary">Add Employee</button>
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
