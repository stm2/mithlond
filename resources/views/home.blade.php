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
                    @if (count($games) < 1)
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


                    <h2>My Factions</h2>
                    @if (count($factions) < 1)
                    <!--  -->
                    <p>You have no factions.</p>
                    <!--  -->
                    @else
                    <p>You have {{ count($factions) }} factions.</p>
                    <ul>
                        @foreach ($factions as $faction)
                        <li>{{ $faction->name }} ({{ $faction->number }}): game <a href="/games/{{ $faction->game->id}}">{{ $faction->game->name }}</a>, <a href="/factions/{{ $faction->id }}/submissions/create">send orders</a>, <a href="/faction/{{ $faction->id }}/reports">reports</a></li>
                        <!--  -->
                        @endforeach
                    </ul>
                    @endif
                    <!--  -->
                    <p><a href="/factions/apply">Apply for a game</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
