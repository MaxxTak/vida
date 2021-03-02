<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FormasPagamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('formas_pagamento')->insert(
            array(
                0 =>
                    array(
                    'id' => 1,
                    'descricao' => 'Dinheiro',
                    'abatimento' => 2.5,
                    'acrescimo' => 0,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ),
                1 =>
                    array(
                    'id' => 2,
                    'descricao' => 'Cartão de Crédito',
                    'abatimento' => 0,
                    'acrescimo' => 2.33,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ),
                2 =>
                    array(
                    'id' => 3,
                    'descricao' => 'Cartão de Débito',
                    'abatimento' => 0,
                    'acrescimo' => 1.15,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ),
                3 =>
                    array(
                    'id' => 4,
                    'descricao' => 'Cheque Pré',
                    'abatimento' => 0,
                    'acrescimo' => 3,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ),
            )
        );
    }
}
