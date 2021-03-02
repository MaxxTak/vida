<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PessoaPermissao extends Model{
    protected $table = 'pessoa_permissao';
    //
    protected $fillable =[
        'permissao_id',
        'user_id'
    ];

    public function permissao()
    {
        return $this->belongsTo(\App\Models\Permissao::class);
    }
}