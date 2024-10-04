<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">Edit Meeting</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('meetings.update', ['id' => $meeting->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body row">
                <div class="col-12 mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $meeting->title) }}" required>
                </div>
                <div class="col-12 mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $meeting->description) }}</textarea>
                </div>
                <div class="col-6 mb-3">
                    <label for="date_time" class="form-label">Date & Time</label>
                    <input type="datetime-local" name="date_time" id="date_time" class="form-control" value="{{ \Carbon\Carbon::parse($meeting->date_time)->format('Y-m-d\TH:i') }}" required>
                </div>
                <div class="col-6 mb-3">
                    <label for="arranged_by" class="form-label">Arranged By</label>
                    <select name="arranged_by" id="arranged_by" class="form-select">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @selected($user->id == $meeting->arranger_id)>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 my-3">
                    <h5 class="mb-4">Arranged With</h5>
                    <div class="row mx-1">
                        @foreach ($users as $user)
                            <div class="form-check col-3">
                                <input class="form-check-input" type="checkbox" name="arranged_with[]" value="{{ $user->id }}" id="arranged_with_{{ $user->id }}" {{ $meeting->participants->contains('user_id', $user->id) ? 'checked' : '' }}>
                                <label class="form-check-label" for="arranged_with_{{ $user->id }}">
                                    {{ $user->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Update Meeting</button>
            </div>
        </form>
    </div>
</div>
