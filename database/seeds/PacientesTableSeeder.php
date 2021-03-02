<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PacientesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('pacientes')->insert(
            array (
                0 => 
                    array (
                        'id' => 1,
                        'profissao' => 'Carteiro',
                        'data_nascimento' => Carbon::now()->format('Y-m-d H:i:s'),
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                1 => 
                    array (
                        'id' => 2,
                        'profissao' => 'Biólogo',
                        'data_nascimento' => Carbon::now()->format('Y-m-d H:i:s'),
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
            )
        );
    }
}
