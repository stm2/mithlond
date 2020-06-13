@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                    @endif

                    <h2>My Games</h2>
                    @if (count($games) <1)
                    <!--  -->
                    <p>You have no games.</p>
                    <!--  -->
                    @else
                    <p>You have {{ count($games) }} games.</p>
                    <ul>
                        @foreach ($games as $game)
                        <li>{{ $game->name }} <a href="/games/{{ $game->id }}">manage</a> <a href="/games/{{ $game->id }}/edit">edit</a> <a
                            href="/games/{{ $game->id }}/confirm_delete">delete</a></li>
                        <!--  -->
                        @endforeach
                    </ul>
                    @endif
                    <!--  -->
                    <p><a href="/games/create">Create new game</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
