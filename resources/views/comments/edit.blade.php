@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('comments.update', $comment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="content">Edit Comment</label>
            <textarea name="content" id="content" class="form-control" required>{{ $comment->content }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
