@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <h1>Update Game</h1>
    </div>
    <div class="row ">
        <form action="/TODO" method="post">
            @csrf {{-- @method('PUT') --}}
            <!--  -->
            <h1>Status of <em>{{$game->name}}</em></h1>
            <p>
                <em>{{$game->description}}</em>
            </p>
            <p>Report email: {{$game->email}}</p>
            <p>Status: {{ $status }}</p>
            <p>
                @isset ($game->currentRound)
                  Next turn: {{ $game->currentRound->round }} ({{ $game->currentRound->deadline }}) <a href="#">edit</a> <a href="#">add</a>
                @else
                  Next turn: not set <a href="#">add</a>
                @endisset
            </p>
            <p>
                {{ count($game->roundsSent) }} / {{ count($game->rounds) }} turns <a href="#">list</a>
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
                Active factions: 000 <a href="#">list</a>
            </p>
            <p>Active players: 000</p>
            <button type="submit" name="button_message" class="btn btn-primary">Send message to all players</button>
            <p>
                Orders sent: 000, confirmed: 000, nmr: 000 <a href="#">list</a>
            </p>
            <p>
                New applications: 000 <a href="#">list</a>
            </p>
            <button type="submit" name="button_close" class="btn btn-primary">Close order reception</button>
            <button type="submit" name="button_download_orders" class="btn btn-primary">Download
                orders</button>
            <button type="submit" name="button_upload_reports" class="btn btn-primary">Upload
                reports</button>
            <button type="submit" name="button_send_reports" class="btn btn-primary">Send reports</button>
            <button type="submit" name="button_open" class="btn btn-primary">Open order reception</button>
        </form>
    </div>
</div>
@endsection
