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

    public function atualizar($request){

        $model = $this->getById($request->idResponsavel);

        if(isset($request->nome)) $model->nome = $request->nome;
        if(isset($request->telefone)) $model->telefone = $request->telefone;
        if(isset($request->imagem)) $model->imagem = $request->imagem;
        if(isset($request->ativo)) $model->ativo = $request->ativo;

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
}
