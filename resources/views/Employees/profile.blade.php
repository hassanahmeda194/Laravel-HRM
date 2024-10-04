@extends('Layout.master')
@section('main_section')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Profile</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Contacts</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4">
            <div class="card overflow-hidden">
                <div class="bg-primary-subtle">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-3">
                                <h5 class="text-primary">Welcome Back !</h5>
                                <p>It will seem like simplified</p>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="avatar-md profile-user-wid mb-4">
                                <img src="assets/images/users/avatar-1.jpg" alt=""
                                    class="img-thumbnail rounded-circle">
                            </div>
                            <h5 class="font-size-15 text-truncate">{{ $user->name }}</h5>
                            <p class="text-muted mb-0 text-truncate">{{ $user->designation->name }}</p>
                        </div>

                        <div class="col-sm-8">
                            <div class="pt-4">

                                <div class="row">
                                    <div class="col-6">
                                        <h5 class="font-size-15">125</h5>
                                        <p class="text-muted mb-0">Projects</p>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="font-size-15">$1245</h5>
                                        <p class="text-muted mb-0">Revenue</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <a href="javascript: void(0);"
                                        class="btn btn-primary waves-effect waves-light btn-sm">View Profile <i
                                            class="mdi mdi-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Personal Information</h4>
                    <p class="text-muted mb-4">Hi I'm Cynthia Price,has been the industry's standard dummy text To an
                        English person, it will seem like simplified English, as a skeptical Cambridge.</p>
                    <div class="table-responsive">
                        <table class="table table-nowrap mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>

                                <tr>
                                    <th scope="row">Mobile :</th>
                                    <td>{{ $user->employee_basic_info->phone_number }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Date of birth</th>
                                    <td>{{ $user->employee_basic_info->date_of_birth }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Location: </th>
                                    <td>{{ $user->employee_basic_info->address }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Salary: </th>
                                    <td>{{ $user->employement_info->salary }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Shift Start time:</th>
                                    <td>{{ $user->employement_info->shift_start_time }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Shift End time:</th>
                                    <td>{{ $user->employement_info->shift_end_time }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Joining Date:</th>
                                    <td>{{ $user->employement_info->joining_date }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Update Profile</h4>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim mollitia voluptate, sunt atque facilis
                        consequatur sit quisquam at corrupti est nemo nulla cumque vero quam libero labore saepe odit. Quos.

                    </p>
                    <br>
                    <ul class="nav nav-pills nav-justified" role="tablist">
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link active" data-bs-toggle="tab" href="#home-1" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                <span class="d-none d-sm-block">Personal Information</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" href="#profile-1" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                <span class="d-none d-sm-block">Update Password</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" href="#messages-1" role="tab">
                                <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                <span class="d-none d-sm-block">Account Setting</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-bs-toggle="tab" href="#settings-1" role="tab">
                                <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                <span class="d-none d-sm-block">Settings</span>
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane active" id="home-1" role="tabpanel">

                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ $error }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endforeach
                            @endif
                            <form action="{{ route('update.personal.information') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{ request('id') }}" name="user_id">
                                <div class="row pt-2">
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
                                            <input type="tel" class="form-control" id=""
                                                placeholder="+123456789" name="phone_number"
                                                value="{{ $user->employee_basic_info->phone_number }}">
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
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="" class="form-label">CNIC</label>
                                            <input type="text" class="form-control" id=""
                                                placeholder="Enter CNIC number" name="cnic"
                                                value="{{ $user->employee_basic_info->cnic }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Address</label>
                                            <textarea rows="4" class="form-control" name="address">{{ $user->employee_basic_info->address ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" type="submit">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="profile-1" role="tabpanel">

                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ $error }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endforeach
                            @endif
                            <form action="{{ route('update.password') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="user_id" value="{{ request('id') }}">
                                    <div class="col-4">
                                        <label for="" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control"
                                            placeholder="Enter new password">
                                    </div>
                                    <div class="col-4">
                                        <label for="" class="form-label">Confirm password</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            placeholder="Rewrite password">
                                    </div>
                                    <div class="col-3 mt-4">
                                        <button class="btn btn-primary" type="submit">Update password</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="tab-pane" id="messages-1" role="tabpanel">
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ $error }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endforeach
                            @endif
                            <form action="{{ route('update.bank.details') }}" method="post">
                                @csrf
                                <input type="hidden" value="{{ request('id') }}" name="user_id">
                                <div class="row">
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
                                    <div class="col-md-4 mt-3">
                                        <button class="btn btn-primary">Update Account Setting</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="settings-1" role="tabpanel">
                            <p class="mb-0">
                                Trust fund seitan letterpress, keytar raw denim keffiyeh etsy
                                art party before they sold out master cleanse gluten-free squid
                                scenester freegan cosby sweater. Fanny pack portland seitan DIY,
                                art party locavore wolf cliche high life echo park Austin. Cred
                                vinyl keffiyeh DIY salvia PBR, banh mi before they sold out
                                farm-to-table.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
