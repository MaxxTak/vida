<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class PessoaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = [
            //
            'name' => 'required|string|max:255',
       //     'email' => 'required|string|email|max:255|unique:users',

         //   'documento' => 'required|string|min:11|unique:users,cnpjcpf|max:14',
  /*
       'username' => 'required|string|unique:users',
            'password' => 'required|string|min:6|confirmed',
  'cep' => 'required',
            'endereco' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'uf' => 'required',*/
        ];

        $tipo = $this->get('tipo');

        switch ($tipo){
            case User::TIPO[User::EMPRESA]:{
                $arr = [
                    'nome_fantasia' => 'required|string|max:255'
                ];
                break;
            }
            case User::TIPO[User::PACIENTE]:{
                $arr = [
                    'documento' => 'required|string|min:11|unique:users,cnpjcpf|max:14',
                //    'profissao'=> 'required',
                 //   'data_nasc'=> 'required',
                ];
                break;
            }
            case User::TIPO[User::PROFISSIONAL]:{
                $arr =[
               //     'cargo'=> 'required',
               //     'registro'=> 'required',
                //    'data_nasc'=> 'required',
                //    'observacao' => 'required'
                ];
                break;
            }
        }

        $user = array_merge($user, $arr);

        return $user;
    }
}
