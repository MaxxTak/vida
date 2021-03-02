<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plano_Contas_Acessorios extends Model
{
    protected $table = 'plano_contas_acessorios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'juros', 'multa', 'mura', 'descontos', 'plano_contas_id'
    ];
}
