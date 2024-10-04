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
                        <h3 class="card-title fs-4 fw-semibold">Manage Leave</h3>
                        <div class="d-flex gap-2">
                            <form action="" method="GET" class="d-flex gap-2">
                                <input type="month" class="form-control" name="month">
                                <button class="btn btn-primary">Filter</button>
                            </form>
                            <div>
                                @can('permission' , 'leave_view')
                                <button class="btn btn-primary" id="mark-leave" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">Mark Leave</button>
                                    @endcan
                            </div>
                        </div>
                    </div>
                    <hr>
                    <br>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>EMP ID</th>
                                <th>UserName</th>
                                <th>Date</th>
                                <th>Leave Type</th>
                                <th>Reason</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leaves as $leave)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $leave->user->name }}</td>
                                    <td>
                                        {{ date('j, M Y', strtotime($leave->date)) }}
                                    </td>
                                    <td>
                                        {{ App\Helpers\CustomHelper::getAttendanceStatus($leave->leave_type) }}
                                    </td>
                                    <td>
                                        {{ $leave->reason }}
                                    </td>
                                    
                                    <td>
                                        @can('permission', 'leave_delete')
                                        <a class="btn btn-outline-danger btn-sm edit-btn"
                                            href="{{ route('delete.leave', ['id' => $leave->id]) }}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                         @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div id="exampleModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Mark Leave</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('leave.store') }}" method="POST">
                        @csrf
                        <div class="modal-body row">
                            <div class="col-6 mb-3">
                                <label for="" class="form-label">User</label>
                                <select id="" name="user_id" class="form-select">
                                    <option disabled selected>Select User</option>
                                    @forelse ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @empty
                                        <option>No User Found</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="" class="form-label">Leave Type</label>
                                <select id="" name="leave_type" class="form-select">
                                    <option disabled selected>Select Leave Type</option>
                                    <option value="sick_leave">sick leave</option>
                                    <option value="annual_leave">Aunnal Leave</option>
                                    <option value="casual_leave">Casual Leave</option>
                                    <option value="unpaid_leave">Unpaid Leave</option>
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="" class="form-label">Start Date</label>
                                <input type="date" class="form-control" name="start_date">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="" class="form-label">End Date</label>
                                <input type="date" class="form-control" name="end_date">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Reason</label>
                                <textarea rows="5" name="reason" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary waves-effect">Mark Leave</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
