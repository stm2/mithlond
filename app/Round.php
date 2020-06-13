<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{

    protected $fillable = [
        'round',
        'game_id',
        'deadline',
        'sent'
    ];
}
