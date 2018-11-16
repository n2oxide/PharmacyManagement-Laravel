<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class client extends Model
{
    public $timestamps = false;
    protected $fillable = ['cno','cbirthday','province','city','area','street','csymptom'];
    //
    public function user()
    {
      return $this->hasOne('App\User','cno','cno');
    }
    //连接售出订单
    public function OrderForms()
    {
      return $this->hasMany('App\OrderForm','cno','cno');
    }
}
