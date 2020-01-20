<?php

namespace App\Http\Controllers\Canteen;

use Illuminate\Http\Request;
use App\Produto;
use App\Helpers\Formatacao;

class ProdutoController extends Controller
{
    private $produtoRepo;
    private $user;
    private $estabelecimento;

    public function __construct(){

        $this->produtoRepo = new Produto();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produtos = $this->produtoRepo->getByFiltro();

        return view('canteen.produtos.index', compact('produtos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = $this->produtoRepo->getCategorias();
        return view('canteen.produtos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|min:3|max:100',
            'preco' => 'required',
            'idCategoria' => 'required|integer|exists:categorias,id'
        ], [
            'descricao.required' => 'Favor informar a descrição do produto.',
            'preco.required' => 'Favor informar o preço do produto.',
            'idCategoria.required' => 'Favor informar a categoria do produto.',
            'descricao.min' => 'Descrição deve ter no mínimo 3 caracteres.',
            'descricao.max' => 'Descrição deve ter no máximo 100 caracteres.',
            'idCategoria.integer' => 'Cod. da categoria deve ser numérico'
        ]);

        $request->idEstabelecimento = $this->getIdEstabelecimento();
        $model = $this->produtoRepo->cadastrar($request);

        return redirect('canteen/cardapio');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Responsavel  $responsavel
     * @return \Illuminate\Http\Response
     */
    public function show(Responsavel $responsavel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Responsavel  $responsavel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produto = Produto::where('id', $id)->firstOrFail();
        $produto->preco_venda = Formatacao::formataNumero($produto->preco_venda);

        $categorias = $this->produtoRepo->getCategorias();

        return view("canteen.produtos.edit", \compact(["produto", "categorias"]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'descricao' => 'required|min:3|max:100',
            'preco' => 'required',
            'idCategoria' => 'required|integer|exists:categorias,id'
        ], [
            'descricao.required' => 'Favor informar a descrição do produto.',
            'preco.required' => 'Favor informar o preço do produto.',
            'idCategoria.required' => 'Favor informar a categoria do produto.',
            'descricao.min' => 'Descrição deve ter no mínimo 3 caracteres.',
            'descricao.max' => 'Descrição deve ter no máximo 100 caracteres.',
            'idCategoria.integer' => 'Cod. da categoria deve ser numérico'
        ]);

        $request->idEstabelecimento = $this->getIdEstabelecimento();
        $request->idProduto = $id;
        $model = $this->produtoRepo->atualizar($request);

        return redirect('canteen/cardapio');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Responsavel  $responsavel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Responsavel $responsavel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Responsavel  $responsavel
     * @return \Illuminate\Http\Response
     */
    public function cadastrarCategoria(Request $request)
    {
        $categoria = $this->produtoRepo->cadastrarCategoria($request->categoria, Auth()->user()->id);

        return response()->json($categoria);
    }
}
