<?php

namespace App\Http\Controllers;

use App\Exceptions\NoContentException;
use App\Http\Requests\PessoaRequest;
use App\Http\src\RegistrarUsuarios;
use App\Models\Empresa;
use App\Models\Endereco;
use App\Models\Paciente;
use App\Models\Permissao;
use App\Models\Profissional;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;
use Faker\Generator as Faker;

class PessoaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if(Gate::denies('checarPapeis', Permissao::PERMISSAO_ID[Permissao::STAFF])){
            throw new NoContentException(app('translator')->trans('erro.pesssoa_permissao'), Response::HTTP_CONFLICT);
        }
        $tipo = $request->get('tipo');

        switch ($tipo){
            case 1:{
                return view('pessoa.empresa.register');
                break;
            }
            case 2:{
                return view('pessoa.paciente.register');
                break;
            }
            case 3:{
                return view('pessoa.profissional.register');
                break;
            }
            default:{
                break;
            }
        }

        return view('auth.register',['tipo'=>$tipo]);
    }

    public function retornarView(Request $request){
        if(Gate::denies('checarPapeis', Permissao::PERMISSAO_ID[Permissao::STAFF])){
            throw new NoContentException(app('translator')->trans('erro.pesssoa_permissao'), Response::HTTP_CONFLICT);
        }
        $tipo = $request->get('tipo');


        switch ($tipo){
            case 1:{
                $emp = User::where('empresa_id','<>',null)->with('empresa')->get();
                return view('pessoa.empresa.index',['empresas'=>$emp]);
                break;
            }
            case 2:{
//                $pac = User::where('paciente_id','<>',null)->with('paciente')->get();
//                foreach ($pac as $key => $p){
//                    if(!is_null($p->titular_id))
//                        $pac[$key]->titular = collect(User::find($p->titular_id));
//                    else
//                        $pac[$key]->titular = [];
//                }
                $pac = array();
                return view('pessoa.paciente.index',['pacientes'=>$pac]);
                break;
            }
            case 3:{
                $pro = User::where('profissional_id','<>',null)->with('profissional')->get();
                return view('pessoa.profissional.index',['profissionais'=>$pro]);
                break;
            }
            default:{
                 break;
            }
        }

    }

    public function retornarPesquisa(Request $request){
       // \DB::enableQueryLog(); // Enable query log
        $pac = User::where('paciente_id','<>',null);
        if($request->get('id') != 0){
            $pac->where('id',$request->get('id'));
        }
        if((!empty($request->get('nim')))&& $request->get('nim') != 0){
            $pieces = explode(".", trim($request->get('nim')));
            if(count($pieces) > 1){
                $titular = User::where('nim',$pieces[0])->get();
                if(count($titular) > 0)
                    $pac->whereIn('id', $titular->pluck('id'));
                $pac->where('nim',$pieces[0]);
                if(count($pieces)>1){
                    if($pieces[1]!=1)
                        $pac->where('ordem',$pieces[1]);
                }
            }else{
                $titular = User::where('nim',$request->get('nim'))->get();
                if(count($titular) > 0)
                    $pac->whereIn('id', $titular->pluck('id'));
                $pac->where('nim',$request->get('nim'));
            }

        }
        if(!is_null($request->get('nome'))){
            $pac->where('name','LIKE', '%'.$request->get('nome').'%');
        }
        if(!is_null($request->get('documento'))){
            $pac->where('cnpjcpf','LIKE', '%'.$request->get('documento').'%');
        }
        if(!is_null($request->get('titular'))){
            $pac->where('titular_id',$request->get('titular'));
        }
        if(!is_null($request->get('status'))){
            $pac->where('status',$request->get('status'));;
        }

       $pac = $pac->get();
     //  dd(\DB::getQueryLog()); // Show results of log
//        $pac = User::where('paciente_id','<>',null)->with('paciente')->get();
        foreach ($pac as $key => $p){
            if(!is_null($p->titular_id))
                $pac[$key]->titular = collect(User::find($p->titular_id));
            else
                $pac[$key]->titular = [];
        }
        return view('pessoa.paciente.index',['pacientes'=>$pac]);

    }

    public function retornarIntermediaria(Request $request){
        $id = $request->get('id');
        return view('pessoa.paciente.intermediaria',['id'=>$id]);
    }

    public function retornarCadastro(Request $request){
        if(Gate::denies('checarPapeis', Permissao::PERMISSAO_ID[Permissao::STAFF])){
            throw new NoContentException(app('translator')->trans('erro.pesssoa_permissao'), Response::HTTP_CONFLICT);
        }
        $tipo = $request->get('tipo');
        return view('auth.register',['tipo'=>$tipo]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function inativar($id){
        $user = User::find($id);
        if(!is_null($user)){
            $user->status = 0;
            $user->save();
        }
        return response()->json(array(
            'status' => 'sucesso',
        ),200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PessoaRequest $request)
    {
        //$dt = $request->get('data');
       // dd($dt);
        if(Gate::denies('checarPapeis', Permissao::PERMISSAO_ID[Permissao::CADASTRAR_PESSOA])){
            throw new NoContentException(app('translator')->trans('erro.pesssoa_permissao'), Response::HTTP_CONFLICT);
        }

        $tipo = $request->get('tipo');
        \DB::beginTransaction();
        try{
            $data = collect($request->all());
            $user=null;
            if(!empty($data['documento']))
                $user = User::where('cnpjcpf',$data['documento'])->first();
            if(is_null($user)){
                if($tipo != User::TIPO[User::PROFISSIONAL]){
                    $user= User::create([
                        'name' => $data['name'],
                        'email' => $data['end_eletronico'] ,
                        'password' => !is_null($data['password']) ? $data['password'] : $data['documento'],
                        'username' => !is_null($data['usu']) ? $data['usu'] : $data['documento'],
                        'cnpjcpf' => $data['documento'],
                        'telefone' => !is_null($data['telefone']) ? $data['telefone'] : "",
                    ]);

                }else{
                    $user= User::create([
                        'name' => $request->has('name') ? $request->get('name') : "",
                        'email' => $request->has('end_eletronico') ? $request->get('end_eletronico') : "",
                        'password' => !is_null($data['password']) ? $data['password'] : $data['documento'],
                        'username' => !is_null($data['usu']) ? $data['usu'] : $data['documento'],
                        'cnpjcpf' => $request->has('documento') ? $request->get('documento') : "",
                        'telefone' => !is_null($data['telefone']) ? $data['telefone'] : "",
                    ]);
                }

                $user = User::find($user->id);
                if($request->has('empresa_id')){
                    $emp = User::find($request->get('empresa_id'));
                    if(!is_null($emp))
                        $user->empresa_id = $emp->empresa_id;
                }
                if($request->has('telefone2')){
                    $user->telefone2 = $request->get('telefone2');
                    $user->save();
                }

                $endereco = new Endereco([
                    'cep' => $request->has('cep') ? $request->get('cep') : "",
                    'numero'=> $request->has('numero')? $request->get('numero'): "",
                    'endereco' => $request->has('endereco') ? $request->get('endereco') : "",
                    'complemento' => $request->has('complemento')?$request->get('complemento'):"",
                    'bairro' => $request->has('bairro') ? $request->get('bairro'):"",
                    'cidade' => $request->has('cidade')?$request->get('cidade'):"",
                    'uf' =>$request->has('uf') ? $request->get('uf'):"",
                ]);

                $endereco->save();
                $endereco->user_id= $user->id;
                $endereco->save();
            }

            switch ($tipo){
                case User::TIPO[User::EMPRESA]:{

                    $empresa = new Empresa([
                        'razao_social' => $request->get('name'),
                        'nome_fantasia'=> $request->get('nome_fantasia'),
                    ]);
                    $empresa->save();
                    if($request->has('ramo_atividade')){
                        $empresa->ramo_atividade = $request->get('ramo_atividade');
                        $empresa->save();
                    }
                    $user->empresa_id = $empresa->id;
                    $user->save();


                    break;
                }
                case User::TIPO[User::PACIENTE]:{
//                    $nim = \DB::table('users')->max('nim');
//                    $nim = !is_numeric($nim) ? 1 : $nim+1;

                    if(!is_null($request->get('nim'))){
                        $aux = User::where('nim',$request->get('nim'))->first();
                        if(!is_null($aux)){
                            \DB::rollBack();
                            return Redirect::back()->withErrors(['Erro', 'Nim já cadastrado']);
                        }
                    }

                    $user->nim = $request->get('nim');
//                    $aux = User::where('nim',$request->get('nim'))->first();
//                    if(!is_null($aux))
//                        $user->nim =$nim;
                    $user->save();
                    //$contador = $request->get('contador');
                    $dt = $request->get('data');

                    if(isset($dt['dep_nome'][0])){//(!is_null($contador))||(!($contador==""))){
                        $contador = count($dt['dep_nome']);
                        for($i=0;$i<$contador;$i++){
                            $dependente = User::create([
                                'name' => $dt['dep_nome'][$i],
                                'email' => !is_null($dt['dep_email'][$i])? $dt['dep_email'][$i] : "nada@".$string = preg_replace('/\s+/', '',$dt['dep_nome'][$i].$dt['dep_doc'][$i].$contador).".com",
                                'password' => "1",
                                'username' => !is_null($dt['dep_doc'][$i])? $dt['dep_doc'][$i] : "nada@".$string = preg_replace('/\s+/', '', $dt['dep_nome'][$i].$dt['dep_doc'][$i].$contador).".com",
                                'cnpjcpf' => $dt['dep_doc'][$i],
                                'telefone' => !is_null($dt['dep_tel'][$i])? $dt['dep_tel'][$i] : "",
                            ]);

                            $dependente = User::find($dependente->id);
                            $dependente->titular_id = $user->id;
                            $dependente->ordem = !is_null($dt['dep_ordem'][$i])? $dt['dep_ordem'][$i] : null;
                            $dependente->save();

                            $paciente = new Paciente([
                                'profissao' => null,
                                'data_nascimento' => !is_null($dt['dep_nasc'][$i])? $dt['dep_nasc'][$i] : Carbon::now(),
                            ]);

                            $paciente->save();
                            $paciente->parentesco =  $dt['dep_parentesco'][$i];
                            $paciente->responsavel =  $dt['dep_resp'][$i];

                            $paciente->save();

                            $dependente->paciente_id = $paciente->id;
                            $dependente->save();

                            $end = new Endereco([
                                'cep' => !is_null($dt['cep'][$i])? $dt['cep'][$i] : $request->has('cep') ? $request->get('cep') : "",
                                'numero'=>!is_null($dt['numero'][$i])? $dt['numero'][$i] : $request->has('numero')? $request->get('numero'): "",
                                'endereco' =>!is_null($dt['endereco'][$i])? $dt['endereco'][$i] : $request->has('endereco') ? $request->get('endereco') : "",
                                'complemento' =>!is_null($dt['complemento'][$i])? $dt['complemento'][$i] : $request->has('complemento')?$request->get('complemento'):"",
                                'bairro' =>!is_null($dt['bairro'][$i])? $dt['bairro'][$i] : $request->has('bairro') ? $request->get('bairro'):"",
                                'cidade' =>!is_null($dt['cidade'][$i])? $dt['cidade'][$i] : $request->has('cidade')?$request->get('cidade'):"",
                                'uf' =>!is_null($dt['uf'][$i])? $dt['uf'][$i] : $request->has('uf') ? $request->get('uf'):"",
                            ]);

                            $end->save();
                            $end->user_id= $dependente->id;
                            $end->save();

                        }
                    }

                    $paciente = new Paciente([
                        'profissao' =>$request->has('profissao') ? $request->get('profissao') :"",
                        'data_nascimento' => $request->has('data_nasc')?$request->get('data_nasc'):"",
                    ]);

                    $paciente->save();
                    if(!is_null($request->get('titular'))){
                        $user->titular_id = $request->get('titular'); //código user do titular
                        $aux = User::where('titular_id',$request->get('titular'))->count();
                        $user->ordem = is_numeric($request->get('nim')) ? $request->get('nim') : ($aux+1);
                        $user->nim =null;
                    }

                    $user->paciente_id = $paciente->id;
                    $user->save();

                    break;
                }
                case User::TIPO[User::PROFISSIONAL]:{
                    $contador = $request->get('contador');
                    if((!is_null($contador))||(!($contador==""))){
                        for($i=0;$i<$contador;$i++){
                            $dependente = User::create([
                                'name' => $request->get('dependenteNome_'.($i+1)),
                                'email' => "nada@".$request->get('dependenteDocumento_'.($i+1)).".com",
                                'password' => "1",
                                'username' => $request->get('dependenteDocumento_'.($i+1)),
                                'cnpjcpf' => $request->get('dependenteDocumento_'.($i+1)),
                            ]);

                            $dependente = User::find($dependente->id);
                            $dependente->titular_id = $user->id;
                            $dependente->ordem = ($i+1);
                            $dependente->save();

                            $paciente = new Paciente([
                                'profissao' => $request->has('profissao')?$request->get('profissao'):"",
                                'data_nascimento' => $request->has('data_nasc')?$request->get('data_nasc'):"",
                            ]);

                            $paciente->save();

                            $dependente->paciente_id = $paciente->id;
                            $dependente->save();

                            $end = new Endereco([
                                'cep' => $request->has('cep') ? $request->get('cep') : "",
                                'numero'=> $request->has('numero')? $request->get('numero'): "",
                                'endereco' => $request->has('endereco') ? $request->get('endereco') : "",
                                'complemento' => $request->has('complemento')?$request->get('complemento'):"",
                                'bairro' => $request->has('bairro') ? $request->get('bairro'):"",
                                'cidade' => $request->has('cidade')?$request->get('cidade'):"",
                                'uf' =>$request->has('uf') ? $request->get('uf'):"",
                            ]);

                            $end->save();
                            $end->user_id= $dependente->id;
                            $end->save();

                        }
                    }

                    $profissional = new Profissional([
                        'cargo' => $request->has('cargo')? $request->get('cargo'): "",
                        'registro' => $request->has('registro')? $request->get('registro'):"",
                        'data_nascimento' => $request->has('data_nasc')? $request->get('data_nasc'):"",
                        'observacao' =>$request->has('observacao')? $request->get('observacao') :""
                    ]);

                    $profissional->save();
                    $user->profissional_id = $profissional->id;

                    $user->save();
                    break;
                }
            }
           // \DB::rollBack();
            \DB::commit();
        }catch (\Exception $exception){
            \DB::rollBack();
//            dd($exception);
            \Log::info([$exception->getTraceAsString()]);
            return Redirect::back()->withErrors(['Erro', 'Erro ao Inserir Cadastro']);
        }

        // Valida Pré Cadastro
        $pre_cadastro = $request->get('pre_cadastro');

        if($pre_cadastro)
            return back()->withSuccess(trans('app.success_store'));
        else if($tipo==User::TIPO[User::PACIENTE])
            return redirect(VIDA .'/intermediaria?id='.$user->id)->withSuccess(trans('app.success_store'));
        else
            return redirect(VIDA .'/pessoa?tipo='.$tipo)->withSuccess(trans('app.success_store'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id){
        if(Gate::denies('checarPapeis', Permissao::PERMISSAO_ID[Permissao::EDITAR_PESSOA])){
            throw new NoContentException(app('translator')->trans('erro.pesssoa_permissao'), Response::HTTP_CONFLICT);
        }
        $tipo = $request->get('tipo');

        switch ($tipo){
            case 1:{
                $emp = User::where('empresa_id','<>',null)->with('empresa','endereco','telefone')->where('id',$id)->first();
                return view('pessoa.empresa.edit',['empresa'=>$emp]);
                break;
            }
            case 2:{
                $pac = User::where('paciente_id','<>',null)->with('paciente','endereco','dependente','titular')->where('id',$id)->first();

                return view('pessoa.paciente.edit',['paciente'=>$pac]);
                break;
            }
            case 3:{
                $pro = User::where('profissional_id','<>',null)->with('profissional','endereco','dependente','titular')->where('id',$id)->first();

                return view('pessoa.profissional.edit',['profissional'=>$pro]);
                break;
            }
            default:{
                break;
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Gate::denies('checarPapeis', Permissao::PERMISSAO_ID[Permissao::EDITAR_PESSOA])){
            throw new NoContentException(app('translator')->trans('erro.pesssoa_permissao'), Response::HTTP_CONFLICT);
        }
        $tipo = $request->get('tipo');

        switch ($tipo){
            case 1:{
                $usr = User::find($id);
                $emp = Empresa::find($usr->empresa_id);
                $end = Endereco::where('user_id',$usr->id)->first();

                if($request->has('name')){
                    $usr->name = $request->get('name');
                    $emp->razao_social = $request->get('name');
                }
                if($request->has('nim')){
                    $usr->nim = $request->get('nim');
                }
                if($request->has('nome_fantasia')){
                    $emp->nome_fantasia = $request->get('nome_fantasia');
                }
                if($request->has('documento')){
                    $usr->cnpjcpf = $request->get('documento');
                }
                if($request->has('end_eletronico')){
                    $usr->email = $request->get('end_eletronico');
                }
                if($request->has('ramo_atividade')){
                    $emp->ramo_atividade = $request->get('ramo_atividade');
                }
                if($request->has('cep')){
                    $end->cep = $request->get('cep');
                }
                if($request->has('endereco')){
                    $end->endereco = $request->get('endereco');
                }
                if($request->has('numero')){
                    $end->numero = $request->get('numero');
                }
                if($request->has('complemento')){
                    $end->complemento = $request->get('complemento');
                }
                if($request->has('bairro')){
                    $end->bairro = $request->get('bairro');
                }
                if($request->has('cidade')){
                    $end->cidade = $request->get('cidade');
                }
                if($request->has('uf')){
                    $end->UF = $request->get('uf');
                }
                if($request->has('celular')){
                    //TODO
                }
                if($request->has('telefone')){
                    //TODO
                }
                if($request->has('telefone2')){

                    $usr->telefone2 = $request->get('telefone2');
                }
                if($request->has('usu')){
                    $usr->username = $request->get('usu');
                }
                if($request->has('password')){

                    $pwd = $request->get('password');
                    $usr->fill(['password'=> ($pwd)])->save;
                    //$usr->password = bcrypt($pwd) ;//\Hash::make($pwd);
                    //$usr->password_changed_at = Carbon::now()->toDateTimeString();
                }
                $usr->save();
                $end->save();
                $emp->save();

                return redirect()->route('home');
                break;
            }
            case 2:{
                $usr = User::find($id);

                $pac = Paciente::find($usr->paciente_id);
                $end = Endereco::where('user_id',$usr->id)->first();

                if($request->has('name') || $request->has('nome')){
                    $usr->name = $request->get('name');
                }
                if($request->has('nim')){
                    if((!empty($request->get('nim')))&& $request->get('nim') != 0){
                        $pieces = explode(".", trim($request->get('nim')));
                        if(count($pieces) > 1){
                            $usr->nim = $pieces[0];
//                            $pac->where('nim',$pieces[0]);
                            $usr->ordem = $pieces[1];
//                            $pac->where('ordem',$pieces[1]);
                        }else{
                            $usr->nim = $request->get('nim');
                        }
                    }
                }
                if($request->has('profissao')){
                    $pac->profissao = $request->get('profissao');
                }
                if($request->has('documento')){
                    $usr->cnpjcpf = $request->get('documento');
                }
                if($request->has('end_eletronico')){
                    $usr->email = $request->get('end_eletronico');
                }
                if($request->has('data_nasc')){
                    $pac->data_nascimento = $request->get('data_nasc');
                }
                if($request->has('cep')){
                    $end->cep = $request->get('cep');
                }
                if($request->has('endereco')){
                    $end->endereco = $request->get('endereco');
                }
                if($request->has('numero')){
                    $end->numero = $request->get('numero');
                }
                if($request->has('complemento')){
                    $end->complemento = $request->get('complemento');
                }
                if($request->has('bairro')){
                    $end->bairro = $request->get('bairro');
                }
                if($request->has('cidade')){
                    $end->cidade = $request->get('cidade');
                }
                if($request->has('uf')){
                    $end->UF = $request->get('uf');
                }
                if($request->has('celular')){
                    //TODO
                }
                if($request->has('telefone')){
                    $usr->telefone = $request->get('telefone');
                }

                if($request->has('telefone2')){

                    $usr->telefone2 = $request->get('telefone2');
                }
                if($request->has('usu')){
                    $usr->username = $request->get('usu');
                }
                if($request->has('password')){

                    $pwd = $request->get('password');
                    $usr->fill(['password'=> ($pwd)])->save;

                }
                $usr->save();
                $end->save();
                $pac->save();


                return redirect()->route('home');
                break;
            }
            case 3:{

                $usr = User::find($id);

                $pro = Profissional::find($usr->profissional_id);
                $end = Endereco::where('user_id',$usr->id)->first();

                if($request->has('name')){
                    $usr->name = $request->get('name');
                }
                if($request->has('nim')){
                    $usr->nim = $request->get('nim');
                }
                if($request->has('cargo')){
                    $pro->cargo = $request->get('cargo');
                }
                if($request->has('documento')){
                    $usr->cnpjcpf = $request->get('documento');
                }
                if($request->has('end_eletronico')){
                    $usr->email = $request->get('end_eletronico');
                }
                if($request->has('data_nasc')){
                    $pro->data_nascimento = $request->get('data_nasc');
                }
                if($request->has('registro')){
                    $pro->registro = $request->get('registro');
                }
                if($request->has('observacao')){
                    $pro->observacao = $request->get('observacao');
                }
                if($request->has('cep')){
                    $end->cep = $request->get('cep');
                }
                if($request->has('endereco')){
                    $end->endereco = $request->get('endereco');
                }
                if($request->has('numero')){
                    $end->numero = $request->get('numero');
                }
                if($request->has('complemento')){
                    $end->complemento = $request->get('complemento');
                }
                if($request->has('bairro')){
                    $end->bairro = $request->get('bairro');
                }
                if($request->has('cidade')){
                    $end->cidade = $request->get('cidade');
                }
                if($request->has('uf')){
                    $end->UF = $request->get('uf');
                }
                if($request->has('celular')){
                    //TODO
                }
                if($request->has('telefone')){
                    $usr->telefone = $request->get('telefone');
                }
                if($request->has('telefone2')){
                    $usr->telefone2 = $request->get('telefone2');
                }
                if($request->has('usu')){
                    $usr->username = $request->get('usu');
                }
                if($request->has('password')){

                    $pwd = $request->get('password');
                    $usr->fill(['password'=> ($pwd)])->save;

                }
                $usr->save();
                $end->save();
                $pro->save();

                return redirect()->route('home');
                break;
            }
            default:{
                break;
            }
        }
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::find($id);
        return redirect()->back();
    }
}
