<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'division',
        'name',
        'champion',
        'points',
        'total_points'
    ];

    public $timestamps = false;

    public function winner()
    {
        return $this->hasMany(Fight::class, 'winner_id', 'id');
    }

    public function loser()
    {
        return $this->hasMany(Fight::class, 'loser_id', 'id');
    }

    public function scopeDivisionA($query)
    {
        return $query->where('division', 'A');
    }

    public function scopeDivisionB($query)
    {
        return $query->where('division', 'B');
    }

    public function scopeResult($query, $team, $opponent)
    {
        $win = $query->whereHas('winner', function ($query) use ($opponent, $team) {
            $query->where('loser_id', $opponent)
                ->where('winner_id', $team);
        })->get();

        $result = (count($win) == 0) ? 'loss' : 'win';

        return $result;
    }
}
