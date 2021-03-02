<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plano_Valor extends Model
{
    protected $table = 'plano_valores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'valor', 'adicional_dependente', 'plano_id', 'usuario_cadastro'
    ];

    /* Soft Deletes */
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
}
