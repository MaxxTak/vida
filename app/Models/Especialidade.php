<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidade extends Model
{
    protected $table = 'especialidades';

    protected $fillable = [
        'titulo', 'descricao'
    ];

    /*
    |------------------------------------------------------------------------------------
    | Validations
    |------------------------------------------------------------------------------------
    */
    public static function rules($id = null)
    {
        $commun = [
            'titulo'         => "required",
            'descricao'         => "required",
        ];

        return $commun;
    }
}
