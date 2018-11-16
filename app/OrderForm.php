<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderForm extends Model
{
    public $timestamps=false;
    protected $fillable = ['ono','ano','cno','created_at'];
    //
    public function agency()
    {
      return $this->belongsTo('App\agency','ano','ano');
    }
    public function client()
    {
      return $this->belongsTo('App\client','cno','cno');
    }
    public  function  sellMedicines()
    {
        return $this->hasMany('App\sellMedicines','ono','ono');
    }
}
