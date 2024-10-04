 @extends('Layout.auth-master')
 @section('main_section')
     <div class="row justify-content-center mt-5">
         <div class="col-md-8 col-lg-6 col-xl-5">
             <div class="card overflow-hidden">
                 <div class="bg-primary-subtle">
                     <div class="row">
                         <div class="col-7">
                             <div class="text-primary p-4">
                                 <h5 class="text-primary">Welcome Back !</h5>
                                 <p>Sign in to continue to HRM.</p>
                             </div>
                         </div>
                         <div class="col-5 align-self-end">
                             <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                         </div>
                     </div>
                 </div>
                 <div class="card-body pt-0">
                     <div class="auth-logo">
                         <a href="index-2.html" class="auth-logo-light">
                             <div class="avatar-md profile-user-wid mb-4">
                                 <span class="avatar-title rounded-circle bg-light">
                                     <img src="{{ asset('assets/images/logo-light.svg') }}" alt=""
                                         class="rounded-circle" height="34">
                                 </span>
                             </div>
                         </a>
                         <a href="index-2.html" class="auth-logo-dark">
                             <div class="avatar-md profile-user-wid mb-4">
                                 <span class="avatar-title rounded-circle bg-light">
                                     <img src="{{ asset('assets/images/logo.svg') }}" alt="" class="rounded-circle"
                                         height="34">
                                 </span>
                             </div>
                         </a>
                     </div>
                     <div class="p-2">
                         <form class="form-horizontal" action="{{ route('submit.login') }}" method="POST">
                             @csrf
                             <div class="mb-3">
                                 <label for="username" class="form-label">EMP ID</label>
                                 <input type="text" name="EMP_ID" class="form-control" placeholder="Enter Employee ID">
                                 @error('email')
                                     <span class="text-danger">{{ $message }}</span>
                                 @enderror
                             </div>
                             <div class="mb-3">
                                 <label class="form-label">Password</label>
                                 <div class="input-group auth-pass-inputgroup">
                                     <input type="password" class="form-control" placeholder="Enter password"
                                         name="password">
                                     <button class="btn btn-light " type="button" id="password-addon"><i
                                             class="mdi mdi-eye-outline"></i></button>
                                 </div>
                                 @error('password')
                                     <span class="text-danger">{{ $message }}</span>
                                 @enderror
                             </div>
                             <div class="form-check">
                                 <input class="form-check-input" type="checkbox" id="remember-check">
                                 <label class="form-check-label" for="remember-check">
                                     Remember me
                                 </label>
                             </div>
                             <div class="mt-3 d-grid">
                                 <button class="btn btn-primary waves-effect waves-light" type="submit">Log In</button>
                             </div>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     
 @endsection
