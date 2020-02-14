<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Formatacao;
use App\User;
use Config;

class Responsavel extends Model
{
    protected $table;
    protected $fillable;

    public function __construct(){
    	$this->table = "responsaveis";
    	$this->fillable = ['estabelecimento_id', 'user_id', 'nome', 'telefone', 'imagem', 'ativo'];
    }

    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function cadastrar($request){
        $model = new Responsavel();

        $model->user_id = $this->cadastrarUsuario($request);

        if(isset($request->idEstabelecimento)) $model->estabelecimento_id = $request->idEstabelecimento;
        if(isset($request->nome)) $model->nome = $request->nome;
        if(isset($request->telefone)) $model->telefone = Formatacao::somenteNumeros($request->telefone);
        if(isset($request->imagem)) $model->imagem = $request->imagem;
        $model->ativo = true;

        $model->save();

        return $model;
    }

    private function cadastrarUsuario($arrInsert){
		$model = new User();
		$model->name = $arrInsert->nome;
		$model->email = $arrInsert->email;
        $model->password = Hash::make($arrInsert->senha);
        $model->perfil = Config::get('constants.PERFIL_USUARIO.RESPONSAVEL', 2);

		$model->save();

		return $model->id;
	}

    public function atualizar($id, $request){

        $model = $this->getById($id);

        if(!empty($request->nome)) $model->nome = $request->nome;
        if(!empty($request->telefone)) $model->telefone = Formatacao::somenteNumeros($request->telefone);
        if(!empty($request->celular)) $model->celular = Formatacao::somenteNumeros($request->celular);
        if(!empty($request->cpf)) $model->cpf = Formatacao::somenteNumeros($request->cpf);
        if(!empty($request->cep)) $model->cep = Formatacao::somenteNumeros($request->cep);
        if(!empty($request->rua)) $model->rua = $request->rua;
        if(!empty($request->numero)) $model->numero = $request->numero;
        if(!empty($request->complemento)) $model->complemento = $request->complemento;
        if(!empty($request->bairro)) $model->bairro = $request->bairro;
        if(!empty($request->cidade)) $model->cidade = $request->cidade;
        if(!empty($request->uf)) $model->uf = $request->uf;

        $model->save();

        return $model;
    }

    public function getById($id){
        return Responsavel::where('id', $id)->firstOrFail();
    }

    public function getByFiltro($nome = ''){
        $responsaveis = DB::table('responsaveis');

        if(!empty($nome)){
            $responsaveis->where('nome', 'like', Formatacao::preparaLike($nome));
        }

        $responsaveis->orderBy('nome');

        return $responsaveis->paginate();
    }

    public static function getByUserId($idUser){
		return Responsavel::where('user_id', $idUser)->firstOrFail();
    }
    
    public function updateAsaasCustomer($asaasCustomerId, $idResponsavel){
        $model = Responsavel::where('id', $idResponsavel)->first();

        if(!$model || empty($model->asaas_customer_id)) {
            return;
        }

        $model->asaas_customer_id = $asaasCustomerId;

        $model->save();
    }
}
