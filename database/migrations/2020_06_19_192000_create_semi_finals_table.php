<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemiFinalsTable extends Migration
{
    public function up()
    {
        Schema::create('semi_finals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('semi_finals');
    }
}
