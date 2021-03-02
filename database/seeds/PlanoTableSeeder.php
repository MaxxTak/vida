<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PlanoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('planos')->insert(
            array (
                0 => 
                    array (
                        'id' => 1,
                        'descricao' => 'Plano IntegrallMed',
                        'dependentes' => 5,
                        'valor' => 75,
                        'entrada' => 1,
                        'meses_contrato' => 11,
                        'adicional_dependente' => 15,
                        'plano_contas_id' => 10,
                        'user_id' => null,
                        'usuario_cadastro' => 1,
                        'deleted_at' => null,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                1 => 
                    array (
                        'id' => 2,
                        'descricao' => 'Plano Empresarial',
                        'dependentes' => 4,
                        'valor' => 60,
                        'entrada' => 0,
                        'meses_contrato' => 12,
                        'adicional_dependente' => 15,
                        'plano_contas_id' => 11,
                        'user_id' => null,
                        'usuario_cadastro' => 1,
                        'deleted_at' => null,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                2 => 
                    array (
                        'id' => 3,
                        'descricao' => 'Teste Desativado',
                        'dependentes' => 4,
                        'valor' => 60,
                        'entrada' => 0,
                        'meses_contrato' => 12,
                        'adicional_dependente' => 15,
                        'plano_contas_id' => 11,
                        'user_id' => null,
                        'usuario_cadastro' => 1,
                        'deleted_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
            )
        );
    }
}
