<?php

namespace App\Http\src;

use Illuminate\Http\Request;
class RegistrarUsuarios
{


    public function showRegistrationForm(Request $request)
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {


    }


}
