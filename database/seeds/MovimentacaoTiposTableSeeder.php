<?php

use Illuminate\Database\Seeder;

class MovimentacaoTiposTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('movimentacao_tipos')->delete();
        
        \DB::table('movimentacao_tipos')->insert(array (
            0 => 
            array (
                'id' => 1,
                'descricao' => 'Pagamento',
                'tipo' => 1,
                'sentido' => 'C',
                'created_at' => '2018-12-19 00:05:57',
                'updated_at' => '2018-12-19 00:05:57',
            ),
            1 => 
            array (
                'id' => 2,
                'descricao' => 'Credito',
                'tipo' => 2,
                'sentido' => 'C',
                'created_at' => '2018-12-19 00:06:04',
                'updated_at' => '2018-12-19 00:06:04',
            ),
            2 => 
            array (
                'id' => 3,
                'descricao' => 'Debito',
                'tipo' => 3,
                'sentido' => 'D',
                'created_at' => '2018-12-19 00:06:10',
                'updated_at' => '2018-12-19 00:06:10',
            ),
            3 => 
            array (
                'id' => 4,
                'descricao' => 'Servico',
                'tipo' => 4,
                'sentido' => 'D',
                'created_at' => '2018-12-19 00:06:18',
                'updated_at' => '2018-12-19 00:06:18',
            ),
            4 => 
            array (
                'id' => 5,
                'descricao' => 'Estorno',
                'tipo' => 5,
                'sentido' => 'D',
                'created_at' => '2018-12-19 00:06:25',
                'updated_at' => '2018-12-19 00:06:25',
            ),
            5 => 
            array (
                'id' => 6,
                'descricao' => 'Produto',
                'tipo' => 6,
                'sentido' => 'C',
                'created_at' => '2018-12-19 00:06:33',
                'updated_at' => '2018-12-19 00:06:33',
            ),
            6 => 
            array (
                'id' => 7,
                'descricao' => 'Recorrente',
                'tipo' => 7,
                'sentido' => 'D',
                'created_at' => '2018-12-25 22:04:23',
                'updated_at' => '2018-12-25 22:04:23',
            ),
        ));
        
        
    }
}