<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Finals extends Model
{
    protected $fillable = [
        'team_id'
    ];

    public $timestamps = false;

    public function team()
    {
        return $this->hasOne('App\Team', 'id', 'team_id');
    }
}
