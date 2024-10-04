@extends('Layout.master')
@section('main_section')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title fs-4 fw-semibold">Assets</h3>
                <div>
                    @can('permission', 'assets_create')
                        <a href="{{ route('asset-management.create') }}" class="btn btn-primary">
                            <i class="fa fa-plus-circle me-2"></i>Add Asset
                        </a>
                    @endcan
                </div>
            </div>
            <hr>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Value</th>
                        <th>Purchase Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assets as $asset)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $asset->name }}</td>
                            <td>{{ $asset->description }}</td>
                            <td>{{ $asset->value }}</td>
                            <td>{{ $asset->purchase_date }}</td>
                            <td>
                                @can('permission', 'assets_update')
                                    <a href="{{ route('asset-management.edit', $asset->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                @endcan
                                @can('permission', 'assets_delete')
                                    <form action="{{ route('asset-management.destroy', $asset->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this asset?');">
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
@endsection
