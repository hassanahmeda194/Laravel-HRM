@extends('Layout.master')
@section('main_section')
    <div class="card">
        <div class="card-body">
            <h3 class="card-title fs-4 fw-semibold">Edit Asset</h3>
            <hr>
            <form action="{{ route('asset-management.update', $asset->id) }}" method="POST" class="row">
                @csrf
                @method('PUT')
                <div class="mb-3 col-4">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $asset->name }}"
                        placeholder="Enter asset name" required>
                </div>
                <div class="mb-3 col-4">
                    <label for="value" class="form-label">Value</label>
                    <input type="number" name="value" class="form-control" value="{{ $asset->value }}"
                        placeholder="Enter asset value" required>
                </div>
                <div class="mb-3 col-4">
                    <label for="purchase_date" class="form-label">Purchase Date</label>
                    <input type="date" name="purchase_date" class="form-control" value="{{ $asset->purchase_date }}"
                        required>
                </div>
                <div class="mb-3 col-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Enter asset description">{{ $asset->description }}</textarea>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Update Asset</button>
                </div>
            </form>
        </div>
    </div>
@endsection
