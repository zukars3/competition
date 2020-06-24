<?php

namespace App;

use Faker\Generator as Faker;
use Illuminate\Http\RedirectResponse;

class CompetitionService
{
    public function create(Faker $faker): void
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
    }

    public function play(Faker $faker): void
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

                    $fight = $faker->randomElements([$teams[$i], $teams[$j]], 2);

                    Fight::create([
                        'teams' => $fight[0]->name . ' VS ' . $fight[1]->name,
                        'type' => 'group',
                        'winner_id' => $fight[0]->id,
                        'loser_id' => $fight[1]->id
                    ]);

                    $fight[0]->increment('points');
                    $fight[0]->increment('total_points');
                }
            }
        }

        $divisionA = Team::where('division', 'A')->orderBy('points', 'DESC')->take(4)->get();
        $divisionB = Team::where('division', 'B')->orderBy('points', 'DESC')->take(4)->get();

        $j = 3;

        for ($i = 0; $i < 4; $i++) {
            $fight = $faker->randomElements([$divisionA[$i], $divisionB[$j]], 2);

            Fight::create([
                'teams' => $fight[0]->name . ' VS ' . $fight[1]->name,
                'type' => 'playoff',
                'winner_id' => $fight[0]->id,
                'loser_id' => $fight[1]->id
            ]);

            $semiFinal[] = $fight[0];

            $fight[0]->increment('total_points', 2);
            $j--;
        }

        for ($i = 0; $i <= 2; $i = $i + 2) {
            $fight = $faker->randomElements([$semiFinal[$i], $semiFinal[$i + 1]], 2, false);

            Fight::create([
                'teams' => $fight[0]->name . ' VS ' . $fight[1]->name,
                'type' => 'semi-final',
                'winner_id' => $fight[0]->id,
                'loser_id' => $fight[1]->id
            ]);

            $final[] = $fight[0];

            $fight[0]->increment('total_points', 2);
        }

        $fight = $faker->randomElements([$final[0], $final[1]], 2, false);

        Fight::create([
            'teams' => $fight[0]->name . ' VS ' . $fight[1]->name,
            'type' => 'final',
            'winner_id' => $fight[0]->id,
            'loser_id' => $fight[1]->id
        ]);

        $fight[0]->increment('total_points', 3);
        $fight[0]->update(['champion' => true]);
    }
}
