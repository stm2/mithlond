@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <h1>Start new Game</h1>
    </div>
    <div class="row ">
        <form action="{{ route('games.store') }}" method="post">
            @csrf
            <!--  -->
            @if ($errors->any())
            <div class="alert alert-danger" role="alert">Please fix the following errors</div>
            @endif
            <div class="form-group">
                <label for="title">Game name</label> <input type="text"
                    class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    placeholder="Game name" value="{{ old('name') }}">
                <!--  -->
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror"
                    id="description" name="description" placeholder="description is shown to users">{{ old('description') }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="url">URL</label> <input type="text"
                    class="form-control @error('url') is-invalid @enderror" id="url" name="url"
                    placeholder="https://yourproject.game" value="{{ old('url') }}">
                <!--  -->
                @error('url')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="url">Email</label> <input type="text"
                    class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                    placeholder="Email for sending orders" value="{{ old('email') }}">
                <!--  -->
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection
