<?php
namespace App\Http\Controllers;

use App\Faction;
use App\Game;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FactionOrderController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Order::class, 'order');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "index";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Faction $faction)
    {
        $orders = new Order();
        $orders->faction_id = $faction->id;

        $this->authorize('create', [
            $orders
        ]);

        return view('order_create', [
            'faction' => $faction
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Faction $faction)
    {
        $data = $this->validateOrder($request);

        $orders = new Order($data);
        $orders->faction_id = $faction->id;
        // TODO is it always the current round?
        $orders->round = $faction->game->currentRound->round;

        $this->authorize('create', [
            $orders
        ]);

        $orders->save();

        return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Faction $faction, Order $order)
    {
        return "show";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Faction $faction, Order $order)
    {
        return "edit";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faction $faction, Order $order)
    {
        return "update";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        return "destroy";
    }

    protected function validateOrder(Request $request)
    {
        return $request->validate([
            'orders' => 'required'
        ]);
    }
}
