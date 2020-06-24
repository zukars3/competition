<?php

namespace App\Http\Controllers;

use App\CompetitionService;
use App\Fight;
use App\Team;
use Faker\Generator as Faker;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CompetitionController extends Controller
{
    private CompetitionService $competitionService;

    public function __construct(CompetitionService $competitionService)
    {
        $this->competitionService = $competitionService;
    }


    public function index(): View
    {
        $divisionA = Team::divisionA()->get();
        $divisionB = Team::divisionB()->get();

        $playoff = Fight::where('type', 'playoff')->get();

        $semiFinal = Fight::where('type', 'semi-final')->get();

        $final = Fight::where('type', 'final')->get();

        $champion = Team::where('champion', 1)->get();

        $results = Team::orderBy('total_points', 'DESC')->get();

        return view('home', [
            'divisionA' => $divisionA,
            'divisionB' => $divisionB,
            'playoff' => $playoff,
            'semiFinal' => $semiFinal,
            'final' => $final,
            'champion' => $champion,
            'results' => $results
        ]);
    }

    public function create(Faker $faker): RedirectResponse
    {
        $this->competitionService->create($faker);

        return redirect()->route('home');
    }
}
