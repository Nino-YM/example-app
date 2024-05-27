@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Message</h1>
    <form action="{{ route('messages.update', $message->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="text">Text</label>
            <textarea name="text" id="text" class="form-control" required>{{ $message->text }}</textarea>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
            @if ($message->image)
                <img src="{{ asset('storage/' . $message->image) }}" class="img-fluid mt-2" alt="Message Image">
            @endif
        </div>
        <div class="form-group">
            <label for="tags">Tags (comma separated)</label>
            <input type="text" name="tags" id="tags" class="form-control" value="{{ implode(',', $message->tags) }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
