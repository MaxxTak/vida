<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelacaoPermissoesGrupo extends Model
{
    //
    protected $fillable = [
        'grupo_id',
        'permissao_id'
    ];

    public function permissao(){
        return $this->belongsTo(\App\Models\Permissao::class,'permissao_id','id');
    }

}
