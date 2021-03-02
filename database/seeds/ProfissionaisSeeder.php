<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ProfissionaisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('profissionais')->insert(
            array (
                0 => 
                    array (
                        'id' => 1,
                        'cargo' => 'Sala 101',
                        'registro' => '456123456',
                        'observacao' => 'Testando',
                        'data_nascimento' => Carbon::now()->format('Y-m-d H:i:s'),
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
            )
        );
    }
}
