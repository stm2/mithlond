<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{

    protected $fillable = [
        'text'
    ];

    //
    public function faction()
    {
        return $this->belongsTo('App\Faction');
    }

    public function text()
    {
        return $this->text;
    }
}
