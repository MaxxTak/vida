<?php

namespace App\Models\Financeiro;

use Illuminate\Database\Eloquent\Model;

class Moeda extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
  //  protected $connection = 'company';
    //
    protected $fillable =[
        'descricao',
        'simbolo'

    ];
}
