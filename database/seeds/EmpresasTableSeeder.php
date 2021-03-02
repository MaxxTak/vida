<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EmpresasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('empresas')->insert(
            array (
                0 => 
                    array (
                        'id' => 1,
                        'razao_social' => 'V Nunes Transportes de Bebidas Eireli',
                        'nome_fantasia' => 'Varejão Santa Rita',
                        'ramo_atividade' => 'Supermercadista',
                        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    ),
            )
        );
    }
}
