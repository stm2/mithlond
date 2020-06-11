@extends('layouts.app') @section('content')
<div class="container">
    <div class="row justify-content-center">
        <h1>Delete Game</h1>
    </div>
    <div class="row ">
        <form action="/games/{{$game->id}}" method="post">
            @csrf
            @method('DELETE')
            <!--  -->
            <input type="hidden" id="game_id" name="game_id" value="{{$game->id}}">
            <p>Do you really want to delete the game <em>'{{ $game->name }}'</em>?</p>
            <button type="submit" name="confirm_delete" class="btn btn-primary">Yes</button>
            <button type="submit" name="reject_delete" class="btn btn-primary">No</button>
        </form>
    </div>
</div>
@endsection
