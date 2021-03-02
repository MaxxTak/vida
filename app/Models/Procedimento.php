<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procedimento extends Model
{
    protected $table = 'procedimentos';

    protected $fillable = [
        'descricao', 'especialidade_id', 'usuario_cadastro', 'preparo'
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
        ];

        return $commun;
    }
}
