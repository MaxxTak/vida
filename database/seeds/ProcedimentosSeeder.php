<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ProcedimentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('procedimentos')->insert(
            array (
                0 => 
                    array (
                        'id' => 1,
                        'descricao' => 'Extração Siso Simples',
                        'especialidade_id' => 1,
                        'usuario_cadastro' => 1,
                        'preparo' => '',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                1 => 
                    array (
                        'id' => 2,
                        'descricao' => 'Extração Siso',
                        'especialidade_id' => 1,
                        'usuario_cadastro' => 1,
                        'preparo' => '',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                2 => 
                    array (
                        'id' => 3,
                        'descricao' => 'Avaliação',
                        'especialidade_id' => 1,
                        'usuario_cadastro' => 1,
                        'preparo' => '',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                3 => 
                    array (
                        'id' => 4,
                        'descricao' => 'Consulta Padrão',
                        'especialidade_id' => 2,
                        'usuario_cadastro' => 1,
                        'preparo' => '',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                4 => 
                    array (
                        'id' => 5,
                        'descricao' => 'Sessão Padrão 1hr',
                        'especialidade_id' => 3,
                        'usuario_cadastro' => 1,
                        'preparo' => '',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                5 => 
                    array (
                        'id' => 6,
                        'descricao' => 'Consulta Padrão',
                        'especialidade_id' => 4,
                        'usuario_cadastro' => 1,
                        'preparo' => '',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                6 => 
                    array (
                        'id' => 7,
                        'descricao' => 'Consulta Padrão',
                        'especialidade_id' => 5,
                        'usuario_cadastro' => 1,
                        'preparo' => '',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                7 => 
                    array (
                        'id' => 8,
                        'descricao' => 'Retorno Consulta',
                        'especialidade_id' => 2,
                        'usuario_cadastro' => 1,
                        'preparo' => '',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                8 => 
                    array (
                        'id' => 9,
                        'descricao' => 'Cirurgia Remoção',
                        'especialidade_id' => 1,
                        'usuario_cadastro' => 1,
                        'preparo' => 'Jejum 12 horas. Escovar os dentes 1 hora antes.',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
            )
        );
    }
}
