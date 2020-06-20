<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinalsTable extends Migration
{
    public function up()
{
    Schema::create('finals', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('team_id');
    });
}

    public function down()
    {
        Schema::dropIfExists('finals');
    }
}
