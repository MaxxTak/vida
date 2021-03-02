<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert(
            array (
                0 =>
                    array (
                        'id' => 1,
                        'name' => 'Admin',
                        'cnpjcpf' => '42143737823',
                        'email' => 'admin@admin.com',
                        'email_verified_at' => NULL,
                        'username' => 'admin',
                        'password' => '$2y$10$zaVQUHXAe71rOQBMcZlOr.IPCmrNUy80eb5/VbAekTdnWYY7tHBhG',
                        'avatar' => NULL,
                        'empresa_id' => NULL,
                        'paciente_id' => NULL,
                        'nim' => '',
                        'profissional_id' => NULL,
                        'titular_id' => NULL,
                        'role' => 10,
                        'bio' => 'Alice. \'I\'m a--I\'m a--\' \'Well! WHAT are you?\' said Alice, \'and those twelve creatures,\' (she was rather doubtful whether she ought not to lie down upon their faces. There was no more to do anything.',
                            'remember_token' => NULL,
                            'created_at' => NULL,
                            'updated_at' => NULL,
                        ),
                1 =>
                    array (
                        'id' => 2,
                        'name' => 'teste',
                        'cnpjcpf' => '12345678910',
                        'email' => 'teste@teste.com',
                        'email_verified_at' => NULL,
                        'username' => 'teste',
                        'password' => '$2y$10$V1ALlsXpr2DJ5t5zYnssGOLNNmL1Fq9mq1Y0Z2oK.FuTVAiegy1Ie',
                        'avatar' => NULL,
                        'empresa_id' => NULL,
                        'paciente_id' => NULL,
                        'nim' => '',
                        'profissional_id' => NULL,
                        'titular_id' => NULL,
                        'role' => 0,
                        'bio' => NULL,
                        'remember_token' => 'uw97J7wTfyzTwVg3VXFIGkTryCPCRxs60toUS3qLEI4Qad10sV8abo4s9dX7',
                        'created_at' => '2018-10-12 20:29:30',
                        'updated_at' => '2018-10-12 20:29:30',
                    ),
                2 =>
                    array (
                        'id' => 3,
                        'name' => 'akira',
                        'cnpjcpf' => '40658102800',
                        'email' => 'nao@tem.com',
                        'email_verified_at' => NULL,
                        'username' => 'akira',
                        'password' => '$2y$10$6hha5OohsIq8iW0oGwt4Ouagvp7PBV0iN/8sSd6YN5c7bx5heAkGK',
                        'avatar' => NULL,
                        'empresa_id' => NULL,
                        'paciente_id' => NULL,
                        'nim' => '',
                        'profissional_id' => NULL,
                        'titular_id' => NULL,
                        'role' => 0,
                        'bio' => NULL,
                        'remember_token' => NULL,
                        'created_at' => '2018-10-12 22:07:01',
                        'updated_at' => '2018-10-12 22:07:01',
                    ),
                3 =>
                    array (
                        'id' => 4,
                        'name' => 'Varejão Santa Rita',
                        'cnpjcpf' => '11443665000196',
                        'email' => 'naoo@tem.com',
                        'email_verified_at' => NULL,
                        'username' => 'varejao',
                        'password' => '$2y$10$6hha5OohsIq8iW0oGwt4Ouagvp7PBV0iN/8sSd6YN5c7bx5heAkGK',
                        'avatar' => NULL,
                        'empresa_id' => 1,
                        'paciente_id' => NULL,
                        'nim' => '',
                        'profissional_id' => NULL,
                        'titular_id' => NULL,
                        'role' => 0,
                        'bio' => NULL,
                        'remember_token' => NULL,
                        'created_at' => '2018-10-12 22:07:01',
                        'updated_at' => '2018-10-12 22:07:01',
                    ),
                4 =>
                    array (
                        'id' => 5,
                        'name' => 'Marcela Caroline da Silva Pereira',
                        'cnpjcpf' => '40722324839',
                        'email' => 'marcelacspereira@gmail.com',
                        'email_verified_at' => NULL,
                        'username' => '40722324839',
                        'password' => '$2y$10$6hha5OohsIq8iW0oGwt4Ouagvp7PBV0iN/8sSd6YN5c7bx5heAkGK',
                        'avatar' => NULL,
                        'empresa_id' => NULL,
                        'paciente_id' => NULL,
                        'nim' => '',
                        'profissional_id' => 1,
                        'titular_id' => NULL,
                        'role' => 0,
                        'bio' => NULL,
                        'remember_token' => NULL,
                        'created_at' => '2018-10-12 22:07:01',
                        'updated_at' => '2018-10-12 22:07:01',
                    ),
                5 =>
                    array (
                        'id' => 6,
                        'name' => 'José Maria Silva',
                        'cnpjcpf' => '33518234285',
                        'email' => 'josemariasilva@gmail.com',
                        'email_verified_at' => NULL,
                        'username' => '33518234285',
                        'password' => '$2y$10$6hha5OohsIq8iW0oGwt4Ouagvp7PBV0iN/8sSd6YN5c7bx5heAkGK',
                        'avatar' => NULL,
                        'empresa_id' => NULL,
                        'paciente_id' => 1,
                        'nim' => '12',
                        'profissional_id' => NULL,
                        'titular_id' => NULL,
                        'role' => 0,
                        'bio' => NULL,
                        'remember_token' => NULL,
                        'created_at' => '2018-10-12 22:07:01',
                        'updated_at' => '2018-10-12 22:07:01',
                    ),
                6 =>
                    array (
                        'id' => 7,
                        'name' => 'Cláudio Fernando Rafael',
                        'cnpjcpf' => '27024094907',
                        'email' => 'claudio@gmail.com',
                        'email_verified_at' => NULL,
                        'username' => '27024094907',
                        'password' => '$2y$10$6hha5OohsIq8iW0oGwt4Ouagvp7PBV0iN/8sSd6YN5c7bx5heAkGK',
                        'avatar' => NULL,
                        'empresa_id' => NULL,
                        'paciente_id' => 2,
                        'nim' => '13.2',
                        'profissional_id' => NULL,
                        'titular_id' => NULL,
                        'role' => 0,
                        'bio' => NULL,
                        'remember_token' => NULL,
                        'created_at' => '2018-10-12 22:07:01',
                        'updated_at' => '2018-10-12 22:07:01',
                    ),
        ));
    }
}
