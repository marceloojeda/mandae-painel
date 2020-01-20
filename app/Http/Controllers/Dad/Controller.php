<?php

namespace App\Http\Controllers\Dad;

use Config;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Estabelecimento;
use App\Responsavel;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function cantineiroLogado(){
        $perfil = Auth()->user()->perfil;

        return $perfil == Config::get('constants.PERFIL_USUARIO.CANTINEIRO');
    }

    protected function responsavelLogado(){
        $perfil = Auth()->user()->perfil;

        return $perfil == Config::get('constants.PERFIL_USUARIO.RESPONSAVEL');
    }

    protected function getIdEstabelecimento(){

        $user = Auth()->user();

        if ($this->cantineiroLogado()) {
            $estabelecimento = Estabelecimento::getByUserId($user->id);
            return $estabelecimento->id;
        }

        $responsavel = Responsavel::getByUserId($user->id);
        return $responsavel->id;
    }

    protected function getIdResponsavel(){

        if(!$this->responsavelLogado()){
            return 0;
        }

        $user = Auth()->user();
        $responsavel = Responsavel::getByUserId($user->id);
        return $responsavel->id;
    }
}
