<?php
namespace App\Http\Controllers;

use App\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Game::class, 'game');
    }

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
    public function store(Request $request, Game $game)
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
        return view('game_show', [
            'game' => $game,
            'status' => 'Unknown',
            'alerts' => []
        ]);
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

    public function confirm_delete(Request $request, Game $game, $id = null)
    {
        if (! empty($id))
            $game = Game::find($id);
        if (! empty($request->get('game_id')))
            $game = Game::find($request->get('game_id'));

        $this->authorize('delete', $game);

        return view('game_confirm_delete', [
            'game' => $game
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Game $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Game $game, $id = null)
    {
        if (! empty($id))
            $game = Game::find($id);
        if (! empty($request->get('game_id')))
            $game = Game::find($request->get('game_id'));

        if ($request->getMethod() == 'DELETE') {
            if ($request->exists('reject_delete')) {
                // reject
            } else if ($request->exists('confirm_delete')) {
                $game->delete();
            }
        }

        return redirect('/home');
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
