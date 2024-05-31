@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Search Results for "{{ $query }}"</h1>
    @if($posts->count() > 0)
        @foreach ($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        @if($post->user->image)
                            <img src="{{ asset('storage/' . $post->user->image) }}" class="rounded-circle mr-3" alt="Profile Picture" style="width: 40px; height: 40px;">
                        @endif
                        <h5 class="card-title">{{ $post->user->pseudo }}</h5>
                    </div>
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
                </div>
            </div>
        @endforeach
        <div class="d-flex justify-content-center">
            {{ $posts->links('pagination::bootstrap-4') }}
        </div>
    @else
        <p>No posts found matching your query.</p>
    @endif
</div>
@endsection
