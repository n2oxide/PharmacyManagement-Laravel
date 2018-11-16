<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sellMedicines extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ['ono', 'mno','sellNum'];

    public function orderForm()
    {
        return $this->belongsTo('App\OrderForm', 'ono', 'ono');
    }

    public function medicine()
    {
        return $this->belongsTo('App\Medicine', 'mno', 'mno');
    }
}
