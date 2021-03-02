@extends('layouts.basico')

@section('content')
             <h2>Profissional</h2>
             <div class="peer">
                 <a href="/vida/registrar?tipo=3">
                     <button class="btn btn-primary">Cadastrar Novo</button>
                 </a>
             </div>
             @if(count($profissionais))
                 <div id="accordion-container">
                     <h2 class="accordion-header aprovar_func">
                         <p>Profissionais Cadastrados</p>
                     </h2>
                     <div>
                         <table id="tabela-profissionais" class="display" style="width:100%">
                             <thead>
                             <tr>
                                 <th>Nome</th>
                                 <th>Documento</th>
                                 <th>Opções</th>
                             </tr>
                             </thead>
                             <tbody>
                             @foreach($profissionais as $profissional)
                                 <tr>
                                     <td>$profissional->name</td>
                                     <td>$profissional->cnpjcpf</td>
                                     <td>
                                         Opções a ser exibidas
                                     </td>
                                 </tr>
                             @endforeach
                             </tbody>
                         </table>
                     </div>
                 </div>
             @else
                 <h3>Nenhum profissional cadastrado</h3>
             @endif
@endsection

@push('scripts')
    <script src="{{ mix('/js/app.js') }}"></script>
    <script type="text/javascript" src="{!! asset('/js/pessoa/profissional.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('/js/pessoa/tab.js') !!}"></script>
@endpush
