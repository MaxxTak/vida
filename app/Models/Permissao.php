<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permissao extends Model
{
    //
    protected $table = 'permissoes';

    const CADASTRAR_PESSOA = 'Cadastrar Pessoa';
    const EDITAR_PESSOA= 'Editar Pessoa';
    const EXCLUIR_PESSOA = 'Excluir Pessoa';
    const ADMIN = 'Administrador';
    const USER = 'Usuário';
    const SECRETARIA = 'Secretaria da Clínica';
    const STAFF = 'Permissões variadas para empregados das Clínicas';
    const CAIXA = 'Movimentações de caixa';
    const FINANCEIRO = 'Movimentações financeiras';

    const PERMISSAO = [
        1 => self::CADASTRAR_PESSOA,
        2 => self::EDITAR_PESSOA,
        3 => self::EXCLUIR_PESSOA,
        4 => self::ADMIN,
        5 => self::USER,
        6 => self::SECRETARIA,
        7 => self::STAFF,
        8 => self::CAIXA,
        9 => self::FINANCEIRO,
    ];

    const PERMISSAO_ID = [
        self::CADASTRAR_PESSOA => 1,
        self::EDITAR_PESSOA => 2,
        self::EXCLUIR_PESSOA => 3,
        self::ADMIN => 4,
        self::USER => 5,
        self::SECRETARIA => 6,
        self::STAFF => 7,
        self::CAIXA => 8,
        self::FINANCEIRO => 9,

    ];

    protected $fillable =[

    ];

    public function grupo(){
        return $this->hasMany(\App\Models\RelacaoPermissoesGrupo::class,'permissao_id','id');
    }

}
