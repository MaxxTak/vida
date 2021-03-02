<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EnderecoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('enderecos')->insert(
            array (
                0 => 
                    array (
                        'id' => 1,
                        'cep' => '11680000',
                        'endereco' => 'R. Gastao Madeira',
                        'complemento' => 'Apto 42B',
                        'numero' => '601',
                        'bairro' => 'Centro',
                        'cidade' => 'Ubatuba',
                        'UF' => 'SP',
                        'pais' => 'Brasil',
                        'user_id' => 1,
                        'latitude' => null,
                        'longitude' => null,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                1 => 
                    array (
                        'id' => 2,
                        'cep' => '11680000',
                        'endereco' => 'R. Gastao Madeira',
                        'complemento' => 'Apto 42B',
                        'numero' => '601',
                        'bairro' => 'Centro',
                        'cidade' => 'Ubatuba',
                        'UF' => 'SP',
                        'pais' => 'Brasil',
                        'user_id' => 2,
                        'latitude' => null,
                        'longitude' => null,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                2 => 
                    array (
                        'id' => 3,
                        'cep' => '11680000',
                        'endereco' => 'R. Gastao Madeira',
                        'complemento' => 'Apto 42B',
                        'numero' => '601',
                        'bairro' => 'Centro',
                        'cidade' => 'Ubatuba',
                        'UF' => 'SP',
                        'pais' => 'Brasil',
                        'user_id' => 3,
                        'latitude' => null,
                        'longitude' => null,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                3 => 
                    array (
                        'id' => 4,
                        'cep' => '11680000',
                        'endereco' => 'R. Gastao Madeira',
                        'complemento' => 'Apto 42B',
                        'numero' => '601',
                        'bairro' => 'Centro',
                        'cidade' => 'Ubatuba',
                        'UF' => 'SP',
                        'pais' => 'Brasil',
                        'user_id' => 4,
                        'latitude' => null,
                        'longitude' => null,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
                4 => 
                    array (
                        'id' => 5,
                        'cep' => '11680000',
                        'endereco' => 'R. Gastao Madeira',
                        'complemento' => 'Apto 42B',
                        'numero' => '601',
                        'bairro' => 'Centro',
                        'cidade' => 'Ubatuba',
                        'UF' => 'SP',
                        'pais' => 'Brasil',
                        'user_id' => 5,
                        'latitude' => null,
                        'longitude' => null,
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
            )
        );
    }
}
