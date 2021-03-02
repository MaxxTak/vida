<?php

use Illuminate\Database\Seeder;

class FormasPagamentoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('formas_pagamento')->delete();
        
        \DB::table('formas_pagamento')->insert(array (
            0 => 
            array (
                'id' => 1,
                'descricao' => 'Dinheiro',
                'abatimento' => 2.5,
                'acrescimo' => 0.0,
                'tipo' => 0,
                'n_parcelas' => 0,
                'taxa' => 0.0,
                'deleted_at' => NULL,
                'created_at' => '2018-12-25 21:37:33',
                'updated_at' => '2018-12-25 21:37:33',
            ),
            1 => 
            array (
                'id' => 2,
                'descricao' => 'Cartão de Crédito',
                'abatimento' => 0.0,
                'acrescimo' => 2.33,
                'tipo' => 0,
                'n_parcelas' => 5,
                'taxa' => 2.0,
                'deleted_at' => NULL,
                'created_at' => '2018-12-25 21:37:33',
                'updated_at' => '2018-12-25 21:37:33',
            ),
            2 => 
            array (
                'id' => 3,
                'descricao' => 'Cartão de Débito',
                'abatimento' => 0.0,
                'acrescimo' => 1.15,
                'tipo' => 0,
                'n_parcelas' => 0,
                'taxa' => 0.0,
                'deleted_at' => NULL,
                'created_at' => '2018-12-25 21:37:33',
                'updated_at' => '2018-12-25 21:37:33',
            ),
            3 => 
            array (
                'id' => 4,
                'descricao' => 'Cheque Pré',
                'abatimento' => 0.0,
                'acrescimo' => 3.0,
                'tipo' => 0,
                'n_parcelas' => 0,
                'taxa' => 0.0,
                'deleted_at' => NULL,
                'created_at' => '2018-12-25 21:37:33',
                'updated_at' => '2018-12-25 21:37:33',
            ),
        ));
    }
}
