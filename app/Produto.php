<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Estabelecimento;
use Config;
use App\Helpers\Formatacao;

class Produto extends Model
{
    protected $table;
    protected $fillable;

    public function __construct(){
    	$this->table = "produtos";
    	$this->fillable = ['estabelecimento_id', 'categoria_id', 'descricao', 'preco_venda', 'imagem', 'ativo'];
    }

    public function cadastrar($request){
        $model = new Produto();

        if(isset($request->idEstabelecimento)) $model->estabelecimento_id = $request->idEstabelecimento;
        if(isset($request->idCategoria)) $model->categoria_id = $request->idCategoria;
        if(isset($request->descricao)) $model->descricao = $request->descricao;
        if(isset($request->preco)) $model->preco_venda = Formatacao::formataNumero($request->preco, 2, Config::get('constants.DATABASE'));
        if(isset($request->imagem)) $model->imagem = $request->imagem;
        $model->ativo = isset($request->ativo);

        $model->save();

        return $model;
    }

        public function atualizar($request){

            $model = $this->getById($request->idProduto);

            if(isset($request->idCategoria)) $model->categoria_id = $request->idCategoria;
            if(isset($request->descricao)) $model->descricao = $request->descricao;
            if(isset($request->preco)) $model->preco_venda = Formatacao::formataNumero($request->preco, 2, Config::get('constants.DATABASE'));
            if(isset($request->imagem)) $model->imagem = $request->imagem;
            $model->ativo = isset($request->ativo);

            $model->save();

            return $model;
    }

    public function getById($id){
        return Produto::where('id', $id)->firstOrFail();
    }

    public function getByFiltro($descricao = ''){
        $produtos = DB::table('produtos');

        if(!empty($descricao)){
            $produtos->where('descricao', 'like', $descricao);
        }

        $produtos->orderBy('descricao');

        return $produtos->paginate(15);
    }

    public function getCategorias(){
            $categorias = DB::table('categorias')
                ->orderBy('descricao')
                ->get();

            return $categorias;
    }

    public function cadastrarCategoria($descricao, $idUser){
        $estabelecimento = Estabelecimento::getByUserId($idUser);
        $id = DB::table('categorias')->insertGetId([
            'descricao' => $descricao, 
            'estabelecimento_id' => $estabelecimento->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ]);

        return DB::table('categorias')->where('id', $id)->first();
    }
}