<?php
namespace App\Http\Controllers;

use App\Faction;
use App\Game;
use App\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FactionSubmissionController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Submission::class, 'submission');
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
        $submissions = new Submission();
        $submissions->faction_id = $faction->id;

        $this->authorize('create', [
            $submissions
        ]);

        return view('submission_create', [
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
        $data = $this->validateSubmission($request);

        $submission = new Submission($data);
        $submission->faction_id = $faction->id;
        // TODO is it always the current round?
        $submission->round = $faction->game->currentRound->round;

        $this->authorize('create', [
            $submission
        ]);

        $submission->save();

        return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Submission $submission
     * @return \Illuminate\Http\Response
     */
    public function show(Faction $faction, Submission $submission)
    {
        return "show";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Submission $submission
     * @return \Illuminate\Http\Response
     */
    public function edit(Faction $faction, Submission $submission)
    {
        return "edit";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Submission $submission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faction $faction, Submission $submission)
    {
        return "update";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Submission $submission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Submission $submission)
    {
        return "destroy";
    }

    protected function validateSubmission(Request $request)
    {
        return $request->validate([
            'text' => 'required'
        ]);
    }
}
