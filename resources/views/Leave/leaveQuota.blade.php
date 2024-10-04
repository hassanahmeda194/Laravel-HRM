@extends('Layout.master')
@section('main_section')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h3 class="card-title fs-4 fw-semibold">Leave Quota</h3>
                    </div>
                    <hr>
                    <br>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>UserName</th>
                                <th>sick leave</th>
                                <th>casual leave</th>
                                <th>annual leave</th>
                                <th>unpaid leave</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leave_quota as $quota)
                            
                                <tr>
                                    <td>{{ $quota->user->name }}</td>
                                    <td>
                                        <span class="badge badge-pill badge-soft-info fs-5">{{ $quota->sick_leave ?? '0' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-pill badge-soft-success fs-5">{{ $quota->casual_leave ?? '0' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-pill badge-soft-warning fs-5">{{ $quota->annual_leave ?? '0' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-pill badge-soft-danger fs-5">{{ $quota->unpaid_leave ?? '0' }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
