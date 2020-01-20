<?php

namespace App\Http\Controllers\Canteen;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Estabelecimento;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getIdEstabelecimento(){
        $user = Auth()->user();
        $estabelecimento = Estabelecimento::getByUserId($user->id);

        return $estabelecimento->id;
    }
}
