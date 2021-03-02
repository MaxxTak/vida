<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProfissionalProcedimentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('profissional_procedimentos')->insert(
            array (
                0 => 
                    array (
                        'id' => 1,
                        'user_id' => 5,
                        'procedimento_id' => 1,
                        'valor' => 100,
                        'valor_particular' => 125,
                        'valor_repasse' => 25,
                        'percentual_repasse' => 0,
                        'usuario_cadastro' => 1,
                        'tempo_atendimento' => 15,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                1 => 
                    array (
                        'id' => 2,
                        'user_id' => 5,
                        'procedimento_id' => 2,
                        'valor' => 110,
                        'valor_particular' => 135,
                        'valor_repasse' => 0,
                        'percentual_repasse' => 40,
                        'usuario_cadastro' => 1,
                        'tempo_atendimento' => 45,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
            )
        );
    }
}
