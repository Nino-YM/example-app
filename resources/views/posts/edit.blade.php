@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Post</h1>
    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" class="form-control" required>{{ $post->content }}</textarea>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
            @if ($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid mt-2" alt="Post Image">
            @endif
        </div>
        <div class="form-group">
            <label for="tags">Tags (comma separated)</label>
            <input type="text" name="tags" id="tags" class="form-control" value="{{ implode(',', $post->tags) }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
