<?php

namespace Tests\Feature;

use App\Http\Controllers\CompetitionController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
//use Faker\Generator as Faker;
use Faker\Factory as Faker;

class CompetitionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexRoute()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testCompetitionGeneration()
    {
        $faker = Faker::create();

        (new CompetitionController(app('CompetitionService')))->create($faker);

        $this->assertDatabaseHas('fights', [
            'id' => 1
        ]);

        $this->assertDatabaseHas('teams', [
            'id' => 1
        ]);
    }

}
