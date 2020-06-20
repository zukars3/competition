<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFightsTable extends Migration
{
    public function up()
    {
        Schema::create('fights', function (Blueprint $table) {
            $table->id();
            $table->string('teams');
            $table->string('type');
            $table->unsignedBigInteger('winner_id');
            $table->unsignedBigInteger('loser_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fights');
    }
}
