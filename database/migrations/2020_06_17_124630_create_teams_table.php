<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->char('division');
            $table->string('name');
            $table->boolean('champion')->default(0);
            $table->integer('points')->default(0);
            $table->integer('total_points')->default(0);;
        });
    }

    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
