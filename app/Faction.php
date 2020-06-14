<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Faction extends Model
{

    public function game()
    {
        return $this->belongsTo('App\Game');
    }

    public function owner()
    {
        return $this->belongsTo('App\User');
    }
}
