@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Post</h1>
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="content">content</label>
            <textarea name="content" id="content" class="form-control" required>{{ old('content') }}</textarea>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <div class="form-group">
            <label for="tags">Tags (comma separated)</label>
            <input type="content" name="tags" id="tags" class="form-control" value="{{ old('tags') }}">
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
