<?php

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');


/*
|------------------------------------------------------------------------------------
| Admin
|------------------------------------------------------------------------------------
*/
Route::group(['prefix' => VIDA, 'as' => VIDA . '.', 'middleware'=>['auth', 'Role:10']], function () {
    Route::resources([
        'users' => 'UserController',
        'plano_contas' => 'PlanoContaController',
        'especialidade' => 'EspecialidadeController',
        'formas_pagamento' => 'FormasPagamentoController',
        'salas' => 'SalaController',
    ]);
});

Route::group(['prefix' => VIDA, 'as' => VIDA . '.', 'middleware'=>['auth', 'Role:10']], function () {
    Route::post('/procedimentos/getProcedimento', 'ProcedimentoController@getProcedimento');

    Route::resources([
        'procedimentos' => 'ProcedimentoController',
    ]);

});

Route::group(['prefix' => VIDA, 'as' => VIDA . '.', 'middleware'=>['auth', 'Role:10']], function () {
    Route::post('/prontuarios/getCamposProntuario', 'ProntuarioController@getCamposProntuario');
    Route::post('/prontuarios/gravaProntuario', 'ProntuarioController@gravaProntuario');
    Route::post('/prontuarios/getProntuariosPaciente', 'ProntuarioController@getProntuariosPaciente');
    Route::post('/prontuarios/getCamposProntuarioPaciente', 'ProntuarioController@getCamposProntuarioPaciente');

    Route::resources([
        'prontuarios' => 'ProntuarioController',
    ]);
});

Route::resource('/ajax','AjaxController');
Route::post('/addDependente','AjaxController@addDependente');

Route::group(['prefix' => VIDA, 'as' => VIDA . '.', 'middleware'=>['auth', 'Role:10']], function () {
    Route::get('/planos/desativados', 'PlanoController@desativados')->name("planos.desativados");
    Route::resources([
        'planos' => 'PlanoController',
    ]);
    Route::get('/planos/{id}/historico', 'PlanoController@historico')->name("planos.historico");
    Route::get('/planos/{id}/restore', 'PlanoController@restore')->name("planos.restore");
});

Route::group(['prefix' => VIDA, 'as' => VIDA . '.', 'middleware'=>['auth', 'Role:10']], function () {
    Route::post('/profissional_procedimentos/getEspecialidadesProfissional', 'ProfissionalProcedimentoController@getEspecialidadesProfissional');
    Route::post('/profissional_procedimentos/getProcedimentosEspecialidades', 'ProfissionalProcedimentoController@getProcedimentosEspecialidades');
    Route::post('/profissional_procedimentos/getProcedimentosProfissional', 'ProfissionalProcedimentoController@getProcedimentosProfissional');
    Route::post('/profissional_procedimentos/getProcedimentoProfissional', 'ProfissionalProcedimentoController@getProcedimentoProfissional');
    Route::post('/profissional_procedimentos/atualizaProcedimentoProfissional', 'ProfissionalProcedimentoController@atualizaProcedimentoProfissional');
    Route::post('/profissional_procedimentos/adicionaProcedimentoProfissional', 'ProfissionalProcedimentoController@adicionaProcedimentoProfissional');
    Route::get('/profissional_procedimentos/{id}/historico', 'ProfissionalProcedimentoController@historico')->name("profissional_procedimentos.historico");

    Route::resources([
        'profissional_procedimentos' => 'ProfissionalProcedimentoController',
    ]);

});

Route::group(['prefix' => VIDA, 'as' => VIDA . '.', 'middleware'=>['auth', 'Role:10']], function () {
    Route::post('/guias/getGuias', 'MovimentacaoGuiaController@getGuias');
    Route::post('/guias/getGuiasPaciente', 'MovimentacaoGuiaController@getGuiasPaciente');
    Route::post('/guias/getProcedimentosGuia', 'MovimentacaoGuiaController@getProcedimentosGuia');
    Route::post('/guias/alteraSituacaoGuia', 'MovimentacaoGuiaController@alteraSituacaoGuia');
    Route::get('/guias/consultar', 'MovimentacaoGuiaController@consultar')->name("guias.consultar");
    Route::get('/guias/imprimir', 'MovimentacaoGuiaController@imprimir')->name("guias.imprimir");
    Route::get('/guias/editar', 'MovimentacaoGuiaController@editar')->name("guias.editar");

    Route::resources([
        'guias' => 'MovimentacaoGuiaController',
    ]);

});

Route::group(['prefix' => VIDA, 'as' => VIDA . '.', 'middleware'=>['auth', 'Role:10']], function () {
    Route::post('/agendamentos/getAgendamentos', 'MovimentacaoAgendamentoController@getAgendamentos');
    Route::post('/agendamentos/getAgendamento', 'MovimentacaoAgendamentoController@getAgendamento');
    Route::post('/agendamentos/getAgendamentosData', 'MovimentacaoAgendamentoController@getAgendamentosData');
    Route::post('/agendamentos/getAgendamentosHistorico', 'MovimentacaoAgendamentoController@getAgendamentosHistorico');
    Route::post('/agendamentos/verificaConflito', 'MovimentacaoAgendamentoController@verificaConflito');
    Route::get('/agendamentos/consulta', 'MovimentacaoAgendamentoController@consulta')->name("agendamentos.consulta");
    Route::get('/agendamentos/historico', 'MovimentacaoAgendamentoController@historico')->name("agendamentos.historico");

    Route::resources([
        'agendamentos' => 'MovimentacaoAgendamentoController',
    ]);

});

Route::group(['prefix' => VIDA, 'as' => VIDA . '.', 'middleware'=>['auth']], function () {

    Route::get('/', 'DashboardController@index')->name('dash');
    Route::get('/pessoa', 'PessoaController@retornarView')->name('retornar_view');
    Route::get('/intermediaria', 'PessoaController@retornarIntermediaria');
    Route::get('/pessoa/edit/{id}', 'PessoaController@edit')->name('editar_pessoa');
    Route::put('/put/pessoa/{id}', 'PessoaController@update')->name('pessoa.edit');
    Route::get('teste/financeiro','HomeController@testeFinanceiro');
    Route::resource('registrar','PessoaController');
    Route::delete('/deletar/user/{id}','PessoaController@destroy');
    Route::get('/permissao/paciente','PermissaoController@retornarPaciente');
    Route::get('/permissao/profissional','PermissaoController@retornarProfissional');
    Route::get('/permissao/criar','PermissaoController@create')->name('permissao.create');
    Route::get('/permissao/buscar/{id}','AjaxController@buscarPermissao');
    Route::resource('permissao','PermissaoController');
    Route::get('/teste', function (Request $request){
        return "So far so good";
    })->name('teste');

    Route::post('/pessoa/pesquisar', 'PessoaController@retornarPesquisa');
    Route::post('/paciente/permissao', 'PermissaoController@gravarPermissaoPaciente');
    Route::post('/profissional/permissao', 'PermissaoController@gravarPermissaoProfissional');

    Route::get('/movimentacoes', 'FinanceiroController@retornarMovimentacoes')->name('retornar_mov');

    Route::get('/grafico/mensal', 'AjaxController@retornarGraficoMensal');
    Route::get('/acerto', 'FinanceiroController@retornarAcerto');
    Route::get('/extrato', 'FinanceiroController@retornarExtrato');
    Route::get('/agendar', 'FinanceiroController@retornarAgendar');
    Route::get('/baixa', 'FinanceiroController@retornarBaixa');
    Route::get('/parcelas', 'FinanceiroController@retornarParcelas');
    Route::get('/venda', 'FinanceiroController@retornarVenda')->name('venda');
    Route::get('/retroativo', 'FinanceiroController@retornarRetroativo');
    Route::post('/venda/confirmar', 'FinanceiroController@confirmarVenda')->name('confirmar.venda');
    Route::post('/venda/retroativa', 'FinanceiroController@salvarRetroativa');
    Route::post('/confirmacao', 'FinanceiroController@salvarVendaPlano');

    Route::get('/parcela/{id}', 'AjaxController@retornarParcela');
    Route::get('/movimentacao/{id}', 'AjaxController@retornarMovimentacao');

    Route::get('/numero/parcelas/{id}', 'AjaxController@retornarNumeroParcelas');
    Route::get('/valor/parcial/{id}', 'AjaxController@retornarValorParcialVenda');
    Route::post('/ajax/parcela', 'AjaxController@pagarParcela');
    Route::post('/ajax/deletar/parcela', 'AjaxController@deletarParcela');
    Route::post('/ajax/deletar/movimentacao', 'AjaxController@deletarMovimentacao');
    Route::post('/ajax/estornar/parcela', 'AjaxController@estornarParcela');
    Route::post('/ajax/empresa', 'AjaxController@retornarEmpresa');

    Route::get('/relatorio/contas', 'Financeiro\RelatorioController@contasPagarReceber');
    Route::get('/relatorio/movimentacoes', 'Financeiro\RelatorioController@retornarMovimentacao');
    Route::get('/relatorio/parcelas', 'Financeiro\RelatorioController@parcelasPagamentos');

    Route::get('/inativar/pessoa/{id}', 'PessoaController@inativar');

});

Route::get('/', function () {
    return redirect('/' . VIDA);
    //return view('home');
    //return \App\User::all();
});
Route::get('/home', function () {
    return redirect('/' . VIDA);
})->name('home');


Auth::routes();
