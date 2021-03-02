<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(users::class);
        $this->call([
            PacientesTableSeeder::class,
            ProfissionaisSeeder::class,
            EmpresasTableSeeder::class,
            UsersTableSeeder::class,
            PlanoContasTableSeeder::class,
            PlanoTableSeeder::class,
            FormasPagamentoTableSeeder::class,
          //  FormasPagamentoSeeder::class,
            EspecialidadesSeeder::class,
            SalasSeeder::class,
            PermissoesTableSeeder::class,
            ProcedimentosSeeder::class,
            EnderecoSeeder::class,
            PessoaPermissaoTableSeeder::class,
            ProfissionalEspecialidadeTableSeeder::class,
            ProfissionalProcedimentosTableSeeder::class,
            MovimentacaoTiposTableSeeder::class,
        ]);
        //$this->call(MovimentacaoTiposTableSeeder::class);
        //$this->call(FormasPagamentoTableSeeder::class);
    }
}
