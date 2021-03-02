<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    const EMPRESA = "Empresa";
    const PROFISSIONAL = "Profissional";
    const PACIENTE = "Paciente";

    const ATIVO = "Ativo";
    const INATIVO = "Inativo";
    const SEM_PLANO = "Sem Plano";
    const PLANO_VENCIDO = "Plano Vencido";

    const TIPO_ID =[
        1 => self::EMPRESA,
        2 => self::PACIENTE,
        3 => self::PROFISSIONAL
    ];

    const TIPO = [
        self::EMPRESA => 1,
        self::PACIENTE => 2,
        self::PROFISSIONAL => 3

    ];


    const STATUS_ID = [
        0 => self::INATIVO,
        1 => self::ATIVO,
        2 => self::SEM_PLANO,
        3 => self::PLANO_VENCIDO,
    ];

    const STATUS = [
        self::INATIVO => 0,
        self::ATIVO => 1,
        self::SEM_PLANO => 2,
        self::PLANO_VENCIDO => 3,

    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username','cnpjcpf','email', 'password', 'avatar', 'bio', 'role', 'telefone','nim'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /*
    |------------------------------------------------------------------------------------
    | Validations
    |------------------------------------------------------------------------------------
    */
    public static function rules($update = false, $id = null)
    {
        $commun = [
            //'email'    => "required|email|unique:users,email,$id",
            'password' => 'nullable|confirmed',
            'avatar' => 'image',
        ];

        if ($update) {
            return $commun;
        }

        return array_merge($commun, [
            'usu'    => 'required|max:255|unique:users',
           // 'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /*
    |------------------------------------------------------------------------------------
    | Attributes
    |------------------------------------------------------------------------------------
    */
    public function setPasswordAttribute($value='')
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getAvatarAttribute($value)
    {
        if (!$value) {
            return 'http://placehold.it/160x160';
        }

        return config('variables.avatar.public').$value;
    }
    public function setAvatarAttribute($photo)
    {
        $this->attributes['avatar'] = move_file($photo, 'avatar');
    }

    public function empresa()
    {
        return $this->belongsTo(\App\Models\Empresa::class, 'empresa_id','id');
    }
    public function paciente()
    {
        return $this->belongsTo(\App\Models\Paciente::class, 'paciente_id','id');
    }
    public function profissional()
    {
        return $this->belongsTo(\App\Models\Profissional::class, 'profissional_id','id');
    }

    public function titular()
    {
        return $this->belongsTo(\App\User::class, 'titular_id','id');
    }

    public function dependente(){
        return $this->hasMany(\App\User::class, 'titular_id','id');
    }

    public function endereco(){
        return $this->hasOne(\App\Models\Endereco::class, 'user_id','id');
    }

    public function plano(){
        return $this->hasMany(\App\Models\PlanoPessoa::class, 'user_id','id');
    }

    /*
    |------------------------------------------------------------------------------------
    | Boot
    |------------------------------------------------------------------------------------
    */
    public static function boot()
    {
        parent::boot();
        static::updating(function($user)
        {
            $original = $user->getOriginal();

            if (\Hash::check('', $user->password)) {
                $user->attributes['password'] = $original['password'];
            }
        });
    }
}
