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
                    <div class="d-flex">
                        <h3 class="card-title fs-4 fw-semibold">Deduction Setting</h3>
                    </div>
                    <hr>
                    <br>
                    <p class="text-primary">Note: The deducted amount is a percentage of the employee's one day's salary.</p>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Deduction Name</th>
                                <th>Percentage</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deductions as $deduction)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $deduction->name }}</td>
                                    <td>{{ $deduction->deduct_amount }}</td>
                                    <td>
                                        @can('permission' , 'deduction_update') 
                                        <button class="btn btn-primary btn-sm edit-deduction" data-id="{{ $deduction->id }}"
                                          >
                                            <i class="fa fa-edit"></i>
                                        </button>
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
    <div class="modal fade" id="exampleModal">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form action="{{ route('deduction.update') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Deduction</h5>
                        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row align-items-center ">
                            <input type="hidden" name="id" id="detact_amount">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Ammount</label>
                                    <input class="form-control" placeholder="Enter Deduct Amount" name="deduct_amount" id="deduct_amount"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-block w-100">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $('.edit-deduction').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url: "{{ route('deduction.edit') }}",
                method: "GET",
                data: {
                    id: id
                },
                success: function(response) {
                    $('#deduct_amount').val(response.deduct_amount);
                    $('#detact_amount').val(response.id);
                    $('#exampleModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    </script>

@endsection
