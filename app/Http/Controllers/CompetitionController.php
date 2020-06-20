<?php

namespace App\Http\Controllers;

use App\Fight;
use App\Finals;
use App\SemiFinal;
use App\Team;
use Faker\Generator as Faker;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CompetitionController extends Controller
{
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
        $teams = Team::all();

        if (count($teams) !== 0) {
            Team::truncate();
            Fight::truncate();
        }

        for ($i = 0; $i < 8; $i++) {
            Team::create([
                'division' => 'A',
                'name' => $faker->firstNameMale
            ]);

            Team::create([
                'division' => 'B',
                'name' => $faker->firstNameFemale
            ]);
        }

        $this->play($faker);

        return redirect()->route('home');
    }

    public function play(Faker $faker)
    {
        for ($k = 0; $k < 2; $k++) {
            if ($k == 0) {
                $division = 'A';
            } else {
                $division = 'B';
            }

            $teams = Team::where('division', $division)->get();

            for ($i = 0; $i < count($teams); $i++) {
                for ($j = $i + 1; $j < count($teams); $j++) {
                    if ($j == $i) {
                        continue;
                    }

                    $rand = $faker->randomElements([$teams[$i], $teams[$j]], 2);

                    Fight::create([
                        'teams' => $rand[0]->name . ' VS ' . $rand[1]->name,
                        'type' => 'group',
                        'winner_id' => $rand[0]->id,
                        'loser_id' => $rand[1]->id
                    ]);

                    $rand[0]->increment('points');
                    $rand[0]->increment('total_points');
                }
            }
        }

        $divisionA = Team::where('division', 'A')->orderBy('points', 'DESC')->take(4)->get();
        $divisionB = Team::where('division', 'B')->orderBy('points', 'DESC')->take(4)->get();

        $j = 3;

        for ($i = 0; $i < 4; $i++) {
            $rand = $faker->randomElements([$divisionA[$i], $divisionB[$j]], 2);

            Fight::create([
                'teams' => $rand[0]->name . ' VS ' . $rand[1]->name,
                'type' => 'playoff',
                'winner_id' => $rand[0]->id,
                'loser_id' => $rand[1]->id
            ]);

            $semiFinal[] = $rand[0];

            $rand[0]->increment('total_points', 2);
            $j--;
        }

        for ($i = 0; $i <= 2; $i = $i + 2) {
            $rand = $faker->randomElements([$semiFinal[$i], $semiFinal[$i + 1]], 2, false);

            Fight::create([
                'teams' => $rand[0]->name . ' VS ' . $rand[1]->name,
                'type' => 'semi-final',
                'winner_id' => $rand[0]->id,
                'loser_id' => $rand[1]->id
            ]);

            $final[] = $rand[0];

            $rand[0]->increment('total_points', 2);
        }

        $rand = $faker->randomElements([$final[0], $final[1]], 2, false);

        Fight::create([
            'teams' => $rand[0]->name . ' VS ' . $rand[1]->name,
            'type' => 'final',
            'winner_id' => $rand[0]->id,
            'loser_id' => $rand[1]->id
        ]);

        $rand[0]->increment('total_points', 3);
        $rand[0]->update(['champion' => true]);
    }
}
