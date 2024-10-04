<form action="{{ route('branch.update', ['branch' => $branch]) }}" method="POST" enctype="multipart/form-data" class="row">
    @csrf
    @method('PUT')
    <div class="col-4 mb-3">
        <label for="" class="form-label">Branch Name</label>
        <input type="text" name="name" class="form-control" placeholder="Enter Branch Name" value="{{ $branch->name }}" required>
    </div>
    <div class="col-4 mb-3">
        <label for="" class="form-label">City</label>
        <input type="text" name="city" class="form-control" placeholder="Enter City" value="{{ optional($branch)->city }}" required>
    </div>
    <div class="col-4 mb-3">
        <label for="" class="form-label">Country</label>
        <input type="text" name="country" class="form-control" placeholder="Enter Country" value="{{ optional($branch)->country }}" required>
    </div>
    <div class="col-12">
        <button class="btn btn-primary waves-effect waves-light" type="submit">Update Branch</button>
    </div>
</form>
