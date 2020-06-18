@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Status of <em>{{$game->name}}</em>
                </div>
                <div class="card-body">
                    <form action="/games/{{$game->id}}/manage" method="post">
                        @csrf {{-- @method('PUT') --}}
                        <!--  -->
                        <p>
                            <em>{{$game->description}}</em>
                        </p>
                        <p>Report email: {{$game->email}}</p>
                        <p>Status: {{ $status }}</p>
                        <p>
                            @isset ($game->currentRound) Next turn: {{ $game->currentRound->round }}
                            ({{ $game->currentRound->deadline }}) <a href="#">edit</a> <a href="#">add</a>
                            @else Next turn: not set <a href="#">add</a> @endisset
                        </p>
                        <p>
                            {{ count($game->roundsSent) }} / {{ count($game->rounds) }} turns <a
                                href="#">list</a>
                        </p>


                        @if (count($alerts) >0)
                        <ul>
                            @foreach ($alerts as $alert)
                            <li>$alert</li>
                            <!--  -->
                            @endforeach
                        </ul>
                        @endif
                        <p>
                            Active factions: {{ $game->factions->count() }} <a href="#">list</a>
                        </p>
                        <p>
                            Active players: {{ $players->count() }} <a href="/game/broadcast">send
                                message to all players</a>
                        </p>
                        <p>
                            Orders received: {{ $received }}, nmr: {{ $nmr }} <a href="#">manage</a>
                        </p>
                        <p>
                            New applications: 000 <a href="#">manage</a>
                        </p>
                        <p>
                            @isset ($game->currentRound) <a
                                download="orders{{ $game->currentRound }}.txt"
                                href="/games/{{ $game->id }}/submissions">Download orders</a>
                            <!--  -->
                            @else No current turn {{ $game->currentRound }}
                            <!--  -->
                            @endisset
                        </p>
                        <button type="submit" name="button_close" class="btn btn-primary">Close
                            order reception</button>
                        <button type="submit" name="button_upload_reports" class="btn btn-primary">Upload
                            reports</button>
                        <button type="submit" name="button_send_reports" class="btn btn-primary">Send
                            reports</button>
                        <button type="submit" name="button_open" class="btn btn-primary">Open order
                            reception</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
