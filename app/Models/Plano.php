<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plano extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descricao', 'dependentes', 'valor', 'entrada', 'meses_contrato', 'adicional_dependente', 'plano_contas_id', 'user_id', 'usuario_cadastro'
    ];

    /*
    |------------------------------------------------------------------------------------
    | Validations
    |------------------------------------------------------------------------------------
    */
    public static function rules($id = null)
    {
        $commun = [
            'descricao'             => "required|unique:planos",
            'dependentes'           => "required",
            'valor'                 => "required",
            'entrada'               => "required",
            'meses_contrato'        => "required",
            'adicional_dependente'  => "required",
        ];

        return $commun;
    }

    public static function rulesUpdate($id = null)
    {
        $commun = [
            'descricao'             => "required",
            'dependentes'           => "required",
            'valor'                 => "required",
            'adicional_dependente'  => "required",
        ];

        return $commun;
    }

    /* Soft Deletes */
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
}
