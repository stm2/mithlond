<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $games = \App\Game::where('user_id', Auth::id())->get();
        $factions = \App\Faction::where('user_id', Auth::id())->get();
        return view('home', [
            'games' => $games,
            'factions' => $factions
        ]);
    }
}
