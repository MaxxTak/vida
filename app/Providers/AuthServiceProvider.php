<?php

namespace App\Providers;

use App\Models\Permissao;
use App\Models\PessoaGrupo;
use App\Models\PessoaPermissao;
use App\Models\RelacaoPermissoesGrupo;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user){
            $pp = PessoaPermissao::with('permissao')->where('user_id',$user->id)->get();
            $arr = [];

            foreach ($pp as $key=>$p){
                $arr[$key] = $p->permissao->valor;
            }

            $arr2 =[];
            $pg = PessoaGrupo::where('user_id',$user->id)->first();
            if(!is_null($pg)){
                $rel = RelacaoPermissoesGrupo::with('permissao')->where('grupo_id',$pg->grupo_id)->get();
                foreach ($rel as $key=>$r){
                    $arr2[$key] = $r->permissao->valor;
                }
            }

            $array = array_merge($arr,$arr2);

            return in_array(Permissao::PERMISSAO_ID[Permissao::ADMIN],$array);
        });

        Gate::define('checarPapeis',function($user,$permissao){
            $pp = PessoaPermissao::with('permissao')->where('user_id',$user->id)->get();
            $arr = [];
            foreach ($pp as $key=>$p){
                $arr[$key] = $p->permissao->valor;
            }
            $arr2 =[];
            $pg = PessoaGrupo::where('user_id',$user->id)->first();
            if(!is_null($pg)){
                $rel = RelacaoPermissoesGrupo::with('permissao')->where('grupo_id',$pg->grupo_id)->get();
                foreach ($rel as $key=>$r){
                    $arr2[$key] = $r->permissao->valor;
                }
            }

            $array = array_merge($arr,$arr2);

           return in_array($permissao,$array);
        });
        //
    }
}
