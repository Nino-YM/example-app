@extends('layouts.app')

@section('content')
<div class="container">
    @foreach ($posts as $post)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $post->user->name }}</h5>
                <p class="card-text">{{ $post->content }}</p>
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

                @if (auth()->check() && (auth()->id() === $post->user_id || auth()->user()->role_id === 2) && auth()->user()->role_id !== 0)
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                @endif

                <!-- Display Comments -->
                <div class="mt-3">
                    <h6>Comments:</h6>
                    @foreach ($post->comments as $comment)
                        <div class="card mt-2">
                            <div class="card-body">
                                <p class="card-text">{{ $comment->content }}</p>
                                <p class="card-text"><small class="text-muted">Commented by {{ $comment->user->pseudo }} on {{ $comment->created_at->format('d M Y H:i') }}</small></p>
                                @if ($comment->user_id == auth()->id())
                                    <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                @endif
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
