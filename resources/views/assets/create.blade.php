@extends('Layout.master')
@section('main_section')
    <div class="card">
        <div class="card-body">
            <h3 class="card-title fs-4 fw-semibold">Add Asset</h3>
            <hr>
            <form action="{{ route('asset-management.store') }}" method="POST" class="row">
                @csrf
                <div class="mb-3 col-4">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter asset name" required>
                </div>
                <div class="mb-3 col-4">
                    <label for="value" class="form-label">Value</label>
                    <input type="number" name="value" class="form-control" placeholder="Enter asset value" required>
                </div>
                <div class="mb-3 col-4">
                    <label for="purchase_date" class="form-label">Purchase Date</label>
                    <input type="date" name="purchase_date" class="form-control" required>
                </div>
                <div class="mb-3 col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Enter asset description"></textarea>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Add Asset</button>
                </div>
            </form>
        </div>
    </div>
@endsection
