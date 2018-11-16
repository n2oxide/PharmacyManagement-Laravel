<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;

class Medicine extends Model
{

    protected $fillable = ['mno', 'mname', 'mmode', 'mefficacy', 'mnum', 'mouttime'];

    /**连接对应的入货经办人
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agency()
    {
        return $this->belongsTo('App\agency', 'ano', 'ano');
    }

    /**连接多个药物销售订单
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sellMedicines()
    {
        return $this->hasMany('App\sellMedicines', 'mno', 'mno');
    }
}
