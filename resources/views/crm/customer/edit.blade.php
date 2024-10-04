<form action="{{ route('customer.update', ['customer' => $customer]) }}" method="POST" enctype="multipart/form-data"
    class="row">
    @csrf
    @method('PUT')
    <div class="col-4 mb-3">
        <label for="" class="form-label">Full Name</label>
        <input type="text" name="name" class="form-control" placeholder="Enter Full Name"
            value="{{ $customer->name }}" required>
    </div>
    <div class="col-4 mb-3">
        <label for="" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Enter Email"
            value="{{ optional($customer)->email }}" required>
    </div>
    <div class="col-4 mb-3">
        <label for="" class="form-label">Phone</label>
        <input type="text" name="phone_number" class="form-control" placeholder="Enter Phone"
            value="{{ optional($customer)->phone_number }}" required>
    </div>
    <div class="col-4 mb-3">
        <label for="" class="form-label">Country</label>
        <input type="text" name="country" class="form-control" placeholder="Enter Country"
            value="{{ optional($customer)->country }}" required>
    </div>
    <div class="col-12 mb-3">
        <label for="" class="form-label">Address</label>
        <textarea name="address" rows="4" class="form-control">{{ optional($customer)->address }}</textarea>
    </div>
    <div class="col-12">
        <button class="btn btn-primary waves-effect waves-light" type="submit">update Customer</button>
    </div>
</form>
