<?php

use Illuminate\Database\Seeder;

class PermissoesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('permissoes')->insert(
            array(
                0 =>
                    array(
                    'id' => 1,
                    'nome' => 'cadastrar_pessoa',
                    'descricao' => 'Cadastro de pessoas no sistema empresa, funcionario e paciente',
                    'valor' => 1,
                    'status' => 1,
                    'created_at' => '2018-12-01 20:50:43',
                    'updated_at' => '2018-12-01 20:50:43',
                ),
                1 =>
                    array(
                    'id' => 2,
                    'nome' => 'editar_pessoa',
                    'descricao' => 'Editar o cadastro de pessoas no sistema empresa, funcionario e paciente',
                    'valor' => 2,
                    'status' => 1,
                    'created_at' => '2018-12-01 20:50:43',
                    'updated_at' => '2018-12-01 20:50:43',
                ),
                2 =>
                    array(
                    'id' => 3,
                    'nome' => 'excluir_pessoa',
                    'descricao' => 'Excluir o cadastro de pessoas no sistema empresa, funcionario e paciente',
                    'valor' => 3,
                    'status' => 1,
                    'created_at' => '2018-12-01 20:51:17',
                    'updated_at' => '2018-12-01 20:51:17',
                ),
                3 =>
                    array(
                    'id' => 4,
                    'nome' => 'Admin',
                    'descricao' => 'Administrador do sistema, tem permissão para tudo',
                    'valor' => 4,
                    'status' => 1,
                    'created_at' => '2018-12-01 20:52:03',
                    'updated_at' => '2018-12-01 20:52:03',
                ),
                4 =>
                    array(
                    'id' => 5,
                    'nome' => 'User',
                    'descricao' => 'Usuario do sistema, tem permissoes bem limitadas',
                    'valor' => 5,
                    'status' => 1,
                    'created_at' => '2018-12-01 20:54:10',
                    'updated_at' => '2018-12-01 20:54:10',
                ),
                5 =>
                    array(
                    'id' => 6,
                    'nome' => 'Secretaria',
                    'descricao' => 'Uso para a secretaria, agendamentos e mensagens em geral',
                    'valor' => 6,
                    'status' => 1,
                    'created_at' => '2018-12-01 20:58:22',
                    'updated_at' => '2018-12-01 20:58:22',
                ),
                6 =>
                    array(
                    'id' => 7,
                    'nome' => 'Staff',
                    'descricao' => 'Usuário administrador, mas com limites',
                    'valor' => 7,
                    'status' => 1,
                    'created_at' => '2018-12-01 21:00:02',
                    'updated_at' => '2018-12-01 21:00:02',
                ),
                7 =>
                    array(
                    'id' => 8,
                    'nome' => 'Caixa',
                    'descricao' => 'Permissão para uso do caixa',
                    'valor' => 8,
                    'status' => 1,
                    'created_at' => '2018-12-01 21:00:23',
                    'updated_at' => '2018-12-01 21:00:23',
                ),
                8 =>
                    array(
                    'id' => 9,
                    'nome' => 'Financeiro',
                    'descricao' => 'Permissão para uso do caixa',
                    'valor' => 9,
                    'status' => 1,
                    'created_at' => '2018-12-01 21:00:37',
                    'updated_at' => '2018-12-01 21:00:37',
                ),
            )
        );
    }
}
