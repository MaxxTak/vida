<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plano_Conta extends Model
{
    protected $table = 'plano_contas';

    protected $fillable = [
        'descricao', 'classificacao', 'tipo'
    ];

    /*
    |------------------------------------------------------------------------------------
    | Validations
    |------------------------------------------------------------------------------------
    */
    public static function rules($id = null)
    {
        $commun = [
            'descricao'         => "required",
            'classificacao'     => "required|unique:plano_contas",
            'tipo'              => "required",
        ];

        return $commun;
    }
}
