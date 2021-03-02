<?php
/**
 * Created by PhpStorm.
 * User: Thiago Akira Kamida
 */
namespace App\Models\Financeiro;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pessoa extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
//    protected $connection = 'company';
    use SoftDeletes;
    protected $fillable =[
        'codigo_externo'
    ];

    public function contaCorrente()
    {
        return $this->hasOne(\App\Model\ContaCorrente::class,'pessoa_id');
    }

    public function movimentacao()
    {
        return $this->hasMany(\App\Model\Movimentacao::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class,'codigo_externo','id');
    }
}
