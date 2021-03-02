<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoPermissoes extends Model
{
    //
    protected $fillable = [
        'nome',
        'descricao'
    ];

    public function permissao(){
        return $this->hasMany(\App\Models\RelacaoPermissoesGrupo::class,'grupo_id','id');
    }

}
