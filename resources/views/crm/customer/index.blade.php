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
                        <h3 class="card-title fs-4 fw-semibold">Customer</h3>
                        <div>

                            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal"
                                data-bs-target="#add-customer">
                                <i class="fa fa-plus-circle me-2"></i> Add Customer
                            </button>
                        </div>
                    </div>
                    <hr>
                    <br>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone#</th>
                                <th>Country</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->phone_number }}</td>
                                    <td>{{ $customer->country }}</td>
                                    <td class="d-flex gap-2">
                                        <button data-id="{{ $customer->id }}" class="btn btn-primary btn-sm mr-2 edit-btn">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <form action="{{ route('customer.destroy', ['customer' => $customer]) }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm mr-2"> <i
                                                    class="fa fa-trash"></i></button>
                                        </form>
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
        <div id="add-customer" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Add New Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body row">
                            <div class="col-4 mb-3">
                                <label for="" class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Full Name"
                                    required>
                            </div>
                            <div class="col-4 mb-3">
                                <label for="" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Email"
                                    required>
                            </div>
                            <div class="col-4 mb-3">
                                <label for="" class="form-label">Phone</label>
                                <input type="text" name="phone_number" class="form-control" placeholder="Enter Phone"
                                    required>
                            </div>
                            <div class="col-4 mb-3">
                                <label for="" class="form-label">Country</label>
                                <input type="text" name="country" class="form-control" placeholder="Enter Country"
                                    required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Address</label>
                                <textarea name="address" rows="4" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect"
                                data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Add Customer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="editModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal-body">
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        $('.edit-btn').click(function(e) {
            e.preventDefault();
            var customerId = $(this).data('id');
            console.log(customerId);
            var url = `{{ route('customer.edit', ['customer' => ':id']) }}`.replace(':id', customerId);
            $.ajax({
                url: url,
                method: "GET",
                success: function(response) {
                    $('#modal-body').html(response);
                    $('#editModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    </script>

@endsection
