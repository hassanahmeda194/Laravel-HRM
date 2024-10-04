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
                        <h3 class="card-title fs-4 fw-semibold">Holidays</h3>
                        <div>
                            @can('permission' , 'holiday_create')
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                                data-bs-target="#myModal"><i class="fa fa-plus-circle me-2"></i> Add Holidays</button>
                            @endcan
                        </div>
                    </div>
                    <hr>
                    <br>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($holidays as $holiday)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $holiday->name }}</td>
                                    <td>{{ date('j, M Y', strtotime($holiday->date)) }}</td>
                                    <td>
                                       <a class="btn btn-primary btn-sm edit-holiday" href="#"
                                                        data-id="{{ $holiday->id }}"><i class="fa fa-edit">

                                                        </a>
                                               <a class="btn btn-danger btn-sm"
                                                        href="{{ route('holiday.delete', ['id' => $holiday->id]) }}"><i class="fa fa-trash">
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
    <div>
        <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Add Holidays</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('holiday.store') }}" method="POST">
                        @csrf
                        <div class="modal-body row">
                            <div class="col-6">
                                <label for="" class="form-label">Holiday Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Holiday name"
                                    required>
                            </div>
                            <div class="col-6">
                                <label for="" class="form-label">Date</label>
                                <input type="date" name="date" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Add
                                Holiday</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Edit Holiday</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('holiday.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="holiday_id">
                        <div class="modal-body row">
                            <div class="col-6">
                                <label for="" class="form-label">Holiday Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Holiday name"
                                    required id="holiday_name">
                            </div>
                            <div class="col-6">
                                <label for="" class="form-label">Holiday Name</label>
                                <input type="date" name="date" class="form-control" placeholder="Enter Holiday name"
                                    required id="holiday_date">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary waves-effect waves-light" type="submit">update
                                Holiday</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.edit-holiday').click(function(e) {
            e.preventDefault();
            var holidayID = $(this).data('id');
            var url = "{{ route('holiday.edit') }}";
            $.ajax({
                url: url,
                method: "GET",
                data: {
                    id: holidayID
                },
                success: function(response) {
                    $('#holiday_name').val(response.name);
                    $('#holiday_date').val(response.date);
                    $('#holiday_id').val(response.id);
                    $('#editModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    </script>
@endsection
