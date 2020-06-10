@extends('layouts.app') @section('content')
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
                        <li>{{ $game->name }} <a href="/game/edit/{{ $game->id }}">edit</a> <a
                            href="/game/delete/{{ $game->id }}">delete</a></li>
                        <!--  -->
                        @endforeach
                    </ul>
                    @endif
                    <!--  -->
                    <p><a href="/game/create">Create new game</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
