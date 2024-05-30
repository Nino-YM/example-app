@extends('layouts.app')

@section('title')
    Réseau Social Laravel - Mon compte
@endsection

@section('content')
    <div class="container">
        <h1>Mon compte</h1>
        <h3 class="pb-3">Modifier mes informations</h3>
        <div class="row">
            <div class="col-6 mx-auto">
                @if ($user->image)
                    <div>
                        <img src="{{ asset('storage/' . $user->image) }}" class="img-fluid img-thumbnail" style="max-width: 150px;" alt="Profile Picture">
                    </div>
                @endif
                <form action="{{ route('users.destroy', $user) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger mt-3">Supprimer le compte</button>
                </form>
            </div>
            <form class="col-6 mx-auto" action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="pseudo">Nouveau pseudo</label>
                    <input required type="text" class="form-control" placeholder="modifier" name="pseudo" value="{{ $user->pseudo }}" id="pseudo">
                </div>
                <div class="form-group">
                    <label for="image">Nouvelle image</label>
                    <input type="file" class="form-control" name="image" id="image">
                </div>
                <button type="submit" class="btn btn-primary">Valider</button>
            </form>
        </div>
    </div>
@endsection