<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanoPessoa extends Model
{
    //
    use SoftDeletes;
    protected $table = 'planos_pessoas';
    protected $fillable = [
        'user_id',
        'plano_id',
        'status'
    ];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    public function plano()
    {
        return $this->belongsTo(\App\Models\Plano::class, 'plano_id','id');
    }
}
