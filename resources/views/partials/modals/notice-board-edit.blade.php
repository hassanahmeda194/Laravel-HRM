@isset($notice)
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Add New Notice Board</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('notice.board.update', ['id' => $notice->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body row">
                    <div class="col-12 mb-3">
                        <label for="" class="form-label">Notice Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter your Title" required
                            value="{{ $notice->title }}">
                    </div>
                    <div class="col-6 mb-3">
                        <label for="" class="form-label">Status</label>
                        <select name="status" id="" class="form-select">
                            <option value="badge badge-pill badge-soft-success" @selected($notice->status == "badge badge-pill badge-soft-success")>Success</option>
                            <option value="badge badge-pill badge-soft-info" @selected($notice->status == "badge badge-pill badge-soft-info")>Info</option>
                            <option value="badge badge-pill badge-soft-danger" @selected($notice->status == "badge badge-pill badge-soft-danger")> Danger</option>
                            <option value="badge badge-pill badge-soft-warning" @selected($notice->status == "badge badge-pill badge-soft-warning")>Warning</option>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label for="" class="form-label">date</label>
                        <input type="date" name="date" class="form-control" placeholder="Enter Phone" required value="{{ $notice->date }}">
                    </div>
                    <div class="col-12 mb-3">
                        <label for="" class="form-label">description</label>
                        <textarea name="description" rows="4" class="form-control">{{ $notice->description }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary waves-effect waves-light" type="submit">Update Notice
                        Board</button>
                </div>
            </form>
        </div>
    </div>
@endisset
