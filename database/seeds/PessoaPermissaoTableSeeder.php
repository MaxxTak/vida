<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PessoaPermissaoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('pessoa_permissao')->insert(
            array (
                0 => 
                    array (
                        'id' => 1,
                        'user_id' => 1,
                        'permissao_id' => 1,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                1 => 
                    array (
                        'id' => 2,
                        'user_id' => 1,
                        'permissao_id' => 2,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                2 => 
                    array (
                        'id' => 3,
                        'user_id' => 1,
                        'permissao_id' => 3,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                3 => 
                    array (
                        'id' => 4,
                        'user_id' => 1,
                        'permissao_id' => 4,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                4 => 
                    array (
                        'id' => 5,
                        'user_id' => 1,
                        'permissao_id' => 5,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                5 => 
                    array (
                        'id' => 6,
                        'user_id' => 1,
                        'permissao_id' => 6,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                6 => 
                    array (
                        'id' => 7,
                        'user_id' => 1,
                        'permissao_id' => 7,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                7 => 
                    array (
                        'id' => 8,
                        'user_id' => 1,
                        'permissao_id' => 8,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                8 => 
                    array (
                        'id' => 9,
                        'user_id' => 1,
                        'permissao_id' => 9,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
            )
        );
    }
}
