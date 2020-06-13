<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{

    protected $fillable = [
        'name',
        'description',
        'url',
        'email'
    ];

    public function currentRound()
    {
        return $this->belongsTo('App\Round', 'current_round_id');
    }

    public function rounds()
    {
        return $this->hasMany('App\Round');
    }

    public function roundsSent()
    {
        return $this->rounds()->whereNotNull('sent');
    }

    public function roundsNotSent()
    {
        return $this->rounds()->whereNull('sent');
    }
}
