<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fight extends Model
{
    protected $fillable = [
        'teams',
        'type',
        'winner_id',
        'loser_id'
    ];

    public $timestamps = false;
}
