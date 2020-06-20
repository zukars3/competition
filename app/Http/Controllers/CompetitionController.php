<?php

namespace App\Http\Controllers;

use App\Fight;
use App\Finals;
use App\SemiFinal;
use App\Team;
use Faker\Generator as Faker;

class CompetitionController extends Controller
{
    public function index()
    {
        $divisionA = Team::divisionA()->get();
        $divisionB = Team::divisionB()->get();

        $playoffDivisionA = Team::divisionA()
            ->orderBy('points', 'DESC')
            ->get();
        $playoffDivisionB = Team::divisionB()
            ->orderBy('points', 'DESC')
            ->get();
        $semiFinal = SemiFinal::all();
        $final = Finals::all();

        $champion = Team::where('champion', 1)->get();

        $results = Team::orderBy('total_points', 'DESC')->get();

        return view('home', [
            'divisionA' => $divisionA,
            'divisionB' => $divisionB,
            'playoffDivisionA' => $playoffDivisionA,
            'playoffDivisionB' => $playoffDivisionB,
            'semiFinal' => $semiFinal,
            'final' => $final,
            'champion' => $champion,
            'results' => $results
        ]);
    }

    public function create(Faker $faker)
    {
        $teams = Team::all();

        if (count($teams) !== 0) {
            Team::truncate();
            Fight::truncate();
            SemiFinal::truncate();
            Finals::truncate();
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

        foreach ($divisionA as $team) {
            $team->update(['playoff' => true]);
        }

        foreach ($divisionB as $team) {
            $team->update(['playoff' => true]);
        }

        $j = 3;

        for ($i = 0; $i < 4; $i++) {
            $rand = $faker->randomElements([$divisionA[$i], $divisionB[$j]], 2);

            SemiFinal::create([
                'team_id' => $rand[0]->id,
            ]);

            Fight::create([
                'winner_id' => $rand[0]->id,
                'loser_id' => $rand[1]->id
            ]);

            $rand[0]->increment('total_points', 2);
            $rand[0]->update(['semi-final' => true]);
            $j--;
        }

        $semiFinal = SemiFinal::all();

        for ($i = 0; $i <= 2; $i = $i + 2) {
            $rand = $faker->randomElements([$semiFinal[$i], $semiFinal[$i + 1]], 2, false);

            Finals::create([
                'team_id' => $rand[0]->team_id
            ]);

            Fight::create([
                'winner_id' => $rand[0]->team_id,
                'loser_id' => $rand[1]->team_id
            ]);

            $rand[0]->team->increment('total_points', 2);
            $rand[0]->update(['final' => true]);
            $final[] = $rand[0];
        }

        $rand = $faker->randomElements([$final[0], $final[1]], 2, false);
        $rand[0]->team->increment('total_points', 2);
        $rand[0]->team->update(['champion' => true]);
    }
}
