<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SalasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('salas')->insert(
            array (
                0 => 
                    array (
                        'id' => 1,
                        'descricao' => 'Sala 101',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                1 => 
                    array (
                        'id' => 2,
                        'descricao' => 'Sala 102',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                2 => 
                    array (
                        'id' => 3,
                        'descricao' => 'Sala 103',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                3 => 
                    array (
                        'id' => 4,
                        'descricao' => 'Sala 104',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                4 => 
                    array (
                        'id' => 5,
                        'descricao' => 'Sala 105',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                5 => 
                    array (
                        'id' => 6,
                        'descricao' => 'Administração',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
            )
        );
    }
}
