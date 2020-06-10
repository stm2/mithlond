<?php
namespace App\Http\Controllers;

use App\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('game_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validateGame($request);

        $game = new Game($data);
        $game->owner_id = Auth::id();
        $game->save();

        return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Game $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Game $game
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        return view('game_edit', [
            'game' => $game
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Game $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        $data = $this->validateGame($request);

        $game->update($data);

        return redirect('/home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Game $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        //
    }

    protected function validateGame(Request $request)
    {
        return $request->validate([
            'name' => 'required|max:255',
            'description' => 'max:5000',
            'url' => 'nullable|url|max:255',
            'email' => 'required|email:rfc,strict,dns|max:255' // TODO email validation seems to be buggy as hell, e.g. "a@example" passes
        ]);
    }
}
