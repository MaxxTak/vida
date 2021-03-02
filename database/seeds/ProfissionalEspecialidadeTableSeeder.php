<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ProfissionalEspecialidadeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('profissional_especialidades')->insert(
            array (
                0 => 
                    array (
                        'id' => 1,
                        'user_id' => 5,
                        'especialidade_id' => 1,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                1 => 
                    array (
                        'id' => 2,
                        'user_id' => 5,
                        'especialidade_id' => 2,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
            )
        );
    }
}
