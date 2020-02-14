<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Dependente;

class Conta extends Model
{
    protected $table;
    protected $fillable;

    public function __construct(){
    	$this->table = "contas";
    	$this->fillable = ['dependente_id', 'saldo', 'limite_diario'];
    }

    public function cadastrar(Dependente $dependente, $limite){
        $model = new Conta();
        $model->dependente_id = $dependente->id;
        $model->saldo = 0;
        $model->limite_diario = $limite;

        $model->save();

        return $model->id;
    }

    public function dependente()
    {
        return $this->hasOne('App\Dependente', 'id', 'dependente_id');
    }

    public static function atualizarSaldo($idConta, float $valor, $debito = true){
        $conta = Conta::where('id', $idConta)->firstOrFail();

        if($debito) {
            $conta->saldo -= $valor;
        } else {
            $conta->saldo += $valor;
        }

        $conta->save();
    }

    public static function atualizarLimite($idDependente, float $valor){

        $conta = Conta::where('dependente_id', $idDependente)->firstOrFail();

        $conta->limite_diario = $valor;

        $conta->save();
    }
}