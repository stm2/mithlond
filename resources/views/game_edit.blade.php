@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Update Game</div>
                <div class="card-body">
                    <form action="{{ route('games.update', $game->id ) }}" method="post">
                        @csrf @method('PUT')
                        <!--  -->
                        @if ($errors->any())
                        <div class="alert alert-danger" role="alert">Please fix the following errors</div>
                        @endif
                        <div class="form-group">
                            <label for="title">Game name</label> <input type="text"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ $game->name }}">
                            <!--  -->
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea
                                class="form-control @error('description') is-invalid @enderror"
                                id="description" name="description">{{ $game->description }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="url">URL</label> <input type="text"
                                class="form-control @error('url') is-invalid @enderror" id="url"
                                name="url" value="{{ $game->url }}">
                            <!--  -->
                            @error('url')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="url">Email</label> <input type="text"
                                class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ $game->email }}">
                            <!--  -->
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
