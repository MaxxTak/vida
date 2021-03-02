<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PlanoContasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('plano_contas')->insert(
            array (
                0 => 
                    array (
                        'id' => 1,
                        'descricao' => 'ATIVO',
                        'classificacao' => '1',
                        'tipo' => 'SS',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                1 => 
                    array (
                        'id' => 2,
                        'descricao' => 'ATIVO CIRCULANTE',
                        'classificacao' => '1.1',
                        'tipo' => 'SS',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                2 => 
                    array (
                        'id' => 3,
                        'descricao' => 'DISPONÍVEL',
                        'classificacao' => '1.1.01',
                        'tipo' => 'SS',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                3 => 
                    array (
                        'id' => 4,
                        'descricao' => 'CAIXAS',
                        'classificacao' => '1.1.01.01',
                        'tipo' => 'SS',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                4 => 
                    array (
                        'id' => 5,
                        'descricao' => 'Caixa Geral',
                        'classificacao' => '1.1.01.01.0001',
                        'tipo' => 'CX',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                5 => 
                    array (
                        'id' => 6,
                        'descricao' => 'CONTAS BANCOS',
                        'classificacao' => '1.1.01.02',
                        'tipo' => 'SS',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                6 => 
                    array (
                        'id' => 7,
                        'descricao' => 'Banco Inter',
                        'classificacao' => '1.1.01.02.0001',
                        'tipo' => 'CB',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                7 => 
                    array (
                        'id' => 8,
                        'descricao' => 'CRÉDITOS',
                        'classificacao' => '1.1.02',
                        'tipo' => 'SS',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                8 => 
                    array (
                        'id' => 9,
                        'descricao' => 'CRÉDITOS DE PLANOS',
                        'classificacao' => '1.1.02.01',
                        'tipo' => 'SS',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                9 => 
                    array (
                        'id' => 10,
                        'descricao' => 'Plano IntegrallMed',
                        'classificacao' => '1.1.02.01.0001',
                        'tipo' => 'CR',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                10 => 
                    array (
                        'id' => 11,
                        'descricao' => 'Plano Empresarial 1',
                        'classificacao' => '1.1.02.01.0002',
                        'tipo' => 'CR',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                11 => 
                    array (
                        'id' => 12,
                        'descricao' => 'CRÉDITOS DE PROCEDIMENTOS',
                        'classificacao' => '1.1.02.02',
                        'tipo' => 'SS',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                12 => 
                    array (
                        'id' => 13,
                        'descricao' => 'Exames a Receber',
                        'classificacao' => '1.1.02.02.0001',
                        'tipo' => 'CR',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                13 => 
                    array (
                        'id' => 14,
                        'descricao' => 'Procedimentos a Receber',
                        'classificacao' => '1.1.02.02.0002',
                        'tipo' => 'CR',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
            )
        );
    }
}
