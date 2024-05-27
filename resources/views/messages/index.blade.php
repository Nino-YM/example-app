@extends('layouts.app')

@section('content')
<div class="container">
    @foreach ($messages as $message)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $message->user->name }}</h5>
                <p class="card-text">{{ $message->text }}</p>
                @if ($message->image)
                    <img src="{{ asset('storage/' . $message->image) }}" class="img-fluid" alt="Message Image">
                @endif
                <p class="card-text">
                    @if ($message->tags)
                        @foreach ($message->tags as $tag)
                            <span class="badge badge-primary">{{ $tag }}</span>
                        @endforeach
                    @endif
                </p>
                <p class="card-text"><small class="text-muted">Posted on {{ $message->created_at->format('d M Y H:i') }}</small></p>
                <a href="{{ route('messages.edit', $message->id) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('messages.destroy', $message->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    @endforeach

    {{ $messages->links() }}
</div>
@endsection
