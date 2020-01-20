<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;

class AuthenticateController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function cantineiroLogado(){
        $perfil = Auth()->user->perfil;

        return $perfil == Config::get('constants.PERFIL_USUARIO.CANTINEIRO');
    }

    protected function responsavelLogado(){
        $perfil = Auth()->user->perfil;

        return $perfil == Config::get('constants.PERFIL_USUARIO.RESPONSAVEL');
    }
}
