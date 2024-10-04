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
                        <h3 class="card-title fs-4 fw-semibold">Tax</h3>
                        <div>
                            @can('permission', 'taxes_create')
                                <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                                    data-bs-target="#myModal"><i class="fa fa-plus-circle me-2"></i> Add Tax</button>
                            @endcan
                        </div>
                    </div>
                    <hr>
                    <br>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Tax Name</th>
                                <th>rate</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($taxes as $tax)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $tax->name }}</td>
                                    <td>{{ $tax->rate }}</td>
                                    <td>
                                        @can('permission', 'taxes_update')
                                            <form action="{{ route('tax.destroy', $tax->id) }}" method="post"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
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
    <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form action="{{ route('tax.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Tax</h5>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row align-items-center ">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Tax Name</label>
                                    <input class="form-control" placeholder="Add tax Name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Rate</label>
                                    <input type="number" class="form-control" placeholder="Add rate in %" name="rate"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-block">Add Tax</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#all-employee-check').change(function() {
                let value = $(this).prop('checked')
                if (value) {
                    $('#all-employee').hide();
                    $('#employee-dropdown').prop('disabled', true);
                } else {
                    $('#all-employee').show();
                    $('#employee-dropdown').prop('disabled', false);
                }
            });
            $('#all-employee-check').change();
        });
    </script>
@endsection
