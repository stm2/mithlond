<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'orders'
    ];

    //
    public function faction()
    {
        return $this->belongsTo('App\Faction');
    }

    public function orders()
    {
        return $this->orders;
    }
}
