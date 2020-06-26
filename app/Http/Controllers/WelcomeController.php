<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $games = DB::table('games')->get()->count();
        $factions = DB::table('factions')->get()->count();

        $players = DB::table('factions')->select('users.id')
            ->join('users', 'factions.user_id', "=", 'users.id')
            ->groupBy('users.id')
            ->get()
            ->count();

        return view('welcome', [
            'num_games' => $games,
            'num_factions' => $factions,
            'num_players' => $players
        ]);
    }
}
