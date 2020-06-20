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

    public function winner()
    {
        return $this->hasOne('App\Team', 'id', 'winner_id');
    }

    public function loser()
    {
        return $this->belongsTo('App\Team', 'id', 'loser_id');
    }
}
