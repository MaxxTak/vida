<li class="nav-item mT-30 active">
    <a class='sidebar-link' href="{{ route(VIDA . '.dash') }}" default>
        <span class="icon-holder">
            <i class="c-blue-500 ti-home"></i>
        </span>
        <span class="title">Dashboard</span>
    </a>
</li>
<li class="nav-item dropdown">
    <a class="dropdown-toggle" href="javascript:void(0);">
        <span class="icon-holder">
            <i class="c-teal-500 ti-settings"></i>
        </span>
        <span class="title">Administração</span>
        <span class="arrow">
            <i class="ti-angle-right"></i>
        </span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a href="/vida/especialidade">Especialidades</a>
        </li>
        <li>
            <a href="/vida/formas_pagamento">Formas de Pagamento</a>
        </li>
        <li>
            <a href="/vida/plano_contas">Plano de Contas</a>
        </li>
        <li>
            <a href="/vida/procedimentos">Procedimentos</a>
        </li>
        <li>
            <a href="/vida/profissional_procedimentos">Procedimentos / Profissional</a>
        </li>
        <li>
            <a href="/vida/prontuarios">Prontuários</a>
        </li>
        <li>
            <a href="/vida/salas">Salas</a>
        </li>
    </ul>
</li>
<li class="nav-item dropdown">
    <a class="dropdown-toggle" href="javascript:void(0);">
        <span class="icon-holder">
            <i class="c-teal-500 ti-calendar"></i>
        </span>
        <span class="title">Agendamentos</span>
        <span class="arrow">
            <i class="ti-angle-right"></i>
        </span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route(VIDA . '.agendamentos.index') }}">Consultar</a>
        </li>
        <li>
            <a href="{{ route(VIDA . '.agendamentos.historico') }}">Histórico</a>
        </li>
    </ul>
</li>
@can('checarPapeis',\App\Models\Permissao::PERMISSAO_ID[\App\Models\Permissao::STAFF])
    <li class="nav-item dropdown">
        <a class="dropdown-toggle" href="javascript:void(0);">
        <span class="icon-holder">
            <i class="c-teal-500 ti-plus"></i>
        </span>
            <span class="title">Cadastros</span>
            <span class="arrow">
            <i class="ti-angle-right"></i>
        </span>
        </a>

        <ul class="dropdown-menu">
            <li class="nav-item dropdown">
                <a href="javascript:void(0);">
                <span class="icon-holder">
                    <i class="c-teal-500 ti-user"></i>
                </span>
                    <span class="title">Pessoas</span>
                    <span class="arrow">
                    <i class="ti-angle-right"></i>
                </span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="/vida/pessoa?tipo=1">Empresa</a>
                    </li>
                    <li>
                        <a href="/vida/pessoa?tipo=2">Paciente</a>
                    </li>
                    <li>
                        <a href="/vida/pessoa?tipo=3">Profissional</a>
                    </li>
                </ul>
            </li>
        </ul>

        <ul class="dropdown-menu">
            <li class="nav-item dropdown">
                <a href="javascript:void(0);">
                <span class="icon-holder">
                    <i class="c-teal-500 ti-folder"></i>
                </span>
                    <span class="title">Permissão</span>
                    <span class="arrow">
                    <i class="ti-angle-right"></i>
                </span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="/vida/permissao">Criar</a>
                    </li>
                    <li>
                        <a href="/vida/permissao/paciente">Pacientes</a>
                    </li>
                    <li>
                        <a href="/vida/permissao/profissional">Profissionais</a>
                    </li>
                </ul>

            </li>
        </ul>

    </li>
@endcan
<li class="nav-item dropdown">
    <a class="dropdown-toggle" href="javascript:void(0);">
        <span class="icon-holder">
            <i class="c-teal-500 ti-folder"></i>
        </span>
        <span class="title">Planos</span>
        <span class="arrow">
            <i class="ti-angle-right"></i>
        </span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route(VIDA . '.planos.index') }}">Planos</a>
        </li>
        <li>
            <a href="{{ route(VIDA . '.planos.desativados') }}">Desativados</a>
        </li>
    </ul>
</li>
<li class="nav-item dropdown">
    <a class="dropdown-toggle" href="javascript:void(0);">
        <span class="icon-holder">
            <i class="c-teal-500 ti-receipt"></i>
        </span>
        <span class="title">Guias</span>
        <span class="arrow">
            <i class="ti-angle-right"></i>
        </span>
    </a>
    <ul class="dropdown-menu">
        <li>
            <a href="{{ route(VIDA . '.guias.index') }}">Nova</a>
        </li>
        <li>
            <a href="{{ route(VIDA . '.guias.consultar') }}">Consultar</a>
        </li>
    </ul>
</li>
<li class="nav-item dropdown">
    <a class="dropdown-toggle" href="javascript:void(0);">
        <span class="icon-holder">
            <i class="c-teal-500 ti-package"></i>
        </span>
        <span class="title">Financeiro</span>
        <span class="arrow">
            <i class="ti-angle-right"></i>
        </span>
    </a>

    <ul class="dropdown-menu">
        <li class="nav-item dropdown">
            <a href="/vida/venda">
                <span class="icon-holder">
                    <i class="c-teal-500 ti-money"></i>
                </span>
                <span class="title">Venda</span>
            </a>
        </li>
    </ul>

    <ul class="dropdown-menu">
        <li class="nav-item dropdown">
            <a href="/vida/movimentacoes">
                <span class="icon-holder">
                    <i class="c-teal-500 ti-move"></i>
                </span>
                <span class="title">Movimentações</span>
            </a>
        </li>
    </ul>

    <ul class="dropdown-menu">
        <li class="nav-item dropdown">
            <a href="/vida/parcelas">
                <span class="icon-holder">
                    <i class="c-teal-500 ti-split-h"></i>
                </span>
                <span class="title">Parcelas</span>
            </a>
        </li>
    </ul>

    <ul class="dropdown-menu">
        <li class="nav-item dropdown">
            <a href="/vida/baixa">
                <span class="icon-holder">
                    <i class="c-teal-500 ti-anchor"></i>
                </span>
                <span class="title">Baixas</span>
            </a>
        </li>
    </ul>

    <ul class="dropdown-menu">
        <li class="nav-item dropdown">
            <a href="/vida/acerto">
                <span class="icon-holder">
                    <i class="c-teal-500 ti-arrow-circle-down"></i>
                </span>
                <span class="title">Acerto</span>
            </a>
        </li>
    </ul>

  <!--  <ul class="dropdown-menu">
        <li class="nav-item dropdown">
            <a href="/vida/agendar">
                <span class="icon-holder">
                    <i class="c-teal-500 ti-alarm-clock"></i>
                </span>
                <span class="title">Agendar Pagamento</span>
            </a>
        </li>
    </ul>
-->
    <ul class="dropdown-menu">
        <li class="nav-item dropdown">
            <a href="javascript:void(0);">
                <span class="icon-holder">
                    <i class="c-teal-500 ti-agenda"></i>
                </span>
                <span class="title">Relatórios</span>
                <span class="arrow">
                    <i class="ti-angle-right"></i>
                </span>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="/vida/relatorio/parcelas">Relatório de Parcelas</a>
                </li>
                <li>
                    <a href="/vida/relatorio/movimentacoes">Relatório de Movimentações</a>
                </li>
                <li>
                    <a href="/vida/relatorio/contas">Relatório de Contas</a>
                </li>
            </ul>
        </li>
    </ul>
</li>
