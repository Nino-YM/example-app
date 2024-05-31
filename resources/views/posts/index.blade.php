@extends('layouts.app')

@section('content')
<div class="container">
    @foreach ($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    @if ($post->user->image)
                        <img src="{{ asset('storage/' . $post->user->image) }}" class="rounded-circle mr-2" style="width: 40px; height: 40px;" alt="Profile Picture">
                    @endif
                    <h5 class="card-title mb-0">{{ $post->user->pseudo }}</h5>
                </div>
                <p class="card-text mt-2">{{ $post->content }}</p>
                @if ($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid" alt="Post Image">
                @endif
                <p class="card-text">
                    @if (is_array($post->tags))
                        @foreach ($post->tags as $tag)
                            <span class="badge badge-primary">{{ $tag }}</span>
                        @endforeach
                    @endif
                </p>
                <p class="card-text"><small class="text-muted">Posted on {{ $post->created_at->format('d M Y H:i') }}</small></p>

                @can('update', $post)
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">Edit</a>
                @endcan
                @can('delete', $post)
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                @endcan

                <!-- Display Comments -->
                <div class="mt-3">
                    <h6>Comments:</h6>
                    @foreach ($post->comments as $comment)
                        <div class="card mt-2">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    @if ($comment->user->image)
                                        <img src="{{ asset('storage/' . $comment->user->image) }}" class="rounded-circle mr-2" style="width: 30px; height: 30px;" alt="Profile Picture">
                                    @endif
                                    <p class="card-text mb-0">{{ $comment->user->pseudo }}</p>
                                </div>
                                <p class="card-text mt-2">{{ $comment->content }}</p>
                                <p class="card-text"><small class="text-muted">Commented on {{ $comment->created_at->format('d M Y H:i') }}</small></p>
                                @can('update', $comment)
                                    <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                @endcan
                                @can('delete', $comment)
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Add Comment Form -->
                <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mt-3">
                    @csrf
                    <div class="form-group">
                        <label for="content">Add Comment</label>
                        <textarea name="content" id="content" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Comment</button>
                </form>
            </div>
        </div>
    @endforeach

    <div class="d-flex justify-content-center">
        {{ $posts->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
