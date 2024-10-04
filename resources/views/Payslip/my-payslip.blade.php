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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title fs-4 fw-semibold">My Payslip</h3>
                    </div>
                    <hr>
                    <br>
                    <form action="{{ route('download.payslip.index') }}" method="post">
                        @csrf
                        <div class="row align-items-center">
                            <input type="hidden" name="user_id" class="form-control" value="{{ Auth::user()->id }}">

                            <div class="col-4">
                                <label for="" class="form-label">Select Month</label>
                                <input type="month" class="form-control" name="month">
                            </div>
                            <div class="col-2 mt-4">
                                <button type="submit" class="btn btn-primary">Generate Payslip</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
