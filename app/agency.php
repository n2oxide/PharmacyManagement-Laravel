<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class agency extends Model
{
    protected $fillable = ['ano'];

    /**连接对应用户
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\User', 'ano', 'ano');
    }
    /*
     * 连接多个售出订单
     */
    public function orderForms()
    {
        return $this->hasMany('App\OrderForm', 'ano', 'ano');
    }

    /**连接多个购入药物
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medicines()
    {
        return $this->hasMany('App\Medicine', 'ano', 'ano');
    }


}
