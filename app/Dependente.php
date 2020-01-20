<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Formatacao;
use App\User;

class Dependente extends Model
{
    protected $table;
    protected $fillable;

    public function __construct(){
    	$this->table = "dependentes";
        $this->fillable = ['estabelecimento_id', 'responsavel_id', 'nome', 'serie', 'telefone', 'imagem', 
            'data_nascimento', 'sexo', 'senha', 'ativo'];
    }

    public function cadastrar($request){
        $model = new Dependente();

        if(isset($request->idEstabelecimento)) $model->estabelecimento_id = $request->idEstabelecimento;
        if(isset($request->idResponsavel)) $model->responsavel_id = $request->idResponsavel;

        if(isset($request->senha)) {
            $model->user_id = $this->cadastrarUsuario($request);
        }

        if(isset($request->nome)) $model->nome = $request->nome;
        if(isset($request->telefone)) $model->telefone = Formatacao::somenteNumeros($request->telefone);
        if(isset($request->imagem)) $model->imagem = $request->imagem;
        if(isset($request->serie)) $model->serie = $request->serie;
        if(isset($request->sexo)) $model->sexo = $request->sexo;
        if(isset($request->dataNascimento)) $model->data_nascimento = Formatacao::toDate($request->dataNascimento);
        if(isset($request->senha)) $model->senha = Hash::make($request->senha);

        $model->ativo = true;

        $model->save();

        return $model;
    }

    private function cadastrarUsuario($arrInsert){

        $fone = Formatacao::somenteNumeros($arrInsert->telefone);        

		$model = new User();
		$model->name = $arrInsert->nome;
		$model->email = $fone;
        $model->password = Hash::make($arrInsert->senha);
        $model->perfil = \Config::get('constants.PERFIL_USUARIO.DEPENDENTE', 3);
        $model->email_verified_at = now();

		$model->save();

		return $model->id;
	}

    public function atualizar($request){

        $model = $this->getById($request->id);

        if(isset($request->nome)) $model->nome = $request->nome;
        if(isset($request->telefone)) $model->telefone = Formatacao::somenteNumeros($request->telefone);
        if(isset($request->imagem)) $model->imagem = $request->imagem;
        if(isset($request->serie)) $model->serie = $request->serie;
        if(isset($request->sexo)) $model->sexo = $request->sexo;
        if(isset($request->dataNascimento)) $model->data_nascimento = Formatacao::toDate($request->dataNascimento);
        if(isset($request->senha)) $model->senha = Hash::make($request->senha);
        // if(isset($request->ativo)) $model->ativo = Hash::make($request->senha);

        $model->save();

        return $model;
    }

    public function getById($id){
        return Dependente::where('id', $id)->firstOrFail();
    }

    public function getByFiltro($nome = ''){
        $responsaveis = DB::table('responsaveis');

        if(!empty($nome)){
            $responsaveis->where('nome', 'like', Formatacao::preparaLike($nome));
        }

        $responsaveis->orderBy('nome');

        return $responsaveis->paginate();
    }

    public function getByResponsavel($idResponsavel){
        $models = Dependente::where('responsavel_id', $idResponsavel)
            ->orderBy('nome')
            ->get();

        return $models;
    }
}
