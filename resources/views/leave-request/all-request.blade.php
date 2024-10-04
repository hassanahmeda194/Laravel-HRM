@extends('Layout.master')
@section('main_section')
   
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title fs-4 fw-semibold">All Leave Request</h3>
                    </div>
                    <hr>
                    <br>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Start date</th>
                                <th>end date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $request)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $request->title }}</td>
                                    <td>{{ Str::words($request->description, 5, '...') }}</td>
                                    <td>
                                        @if ($request->status == 1)
                                            <span class="badge badge-pill badge-soft-success">Approved</span>
                                        @elseif ($request->status == 0)
                                            <span class="badge badge-pill badge-soft-danger">Rejected</span>
                                        @elseif ($request->status == 2)
                                            <span class="badge badge-pill badge-soft-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($request->start_date)->format('M d, Y') }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('leave.request.approve', ['id' => $request->id]) }}"
                                            class="btn btn-primary btn-sm mr-2 edit-btn">
                                            Approve</i>
                                        </a>
                                        <a href="{{ route('leave.request.reject', ['id' => $request->id]) }}"
                                            class="btn btn-danger btn-sm mr-2">
                                            Reject</i>
                                        </a>
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
