<?php

namespace App\Http\Controllers\Dad;

use App\Responsavel;
use App\Estabelecimento;
use App\Dependente;
use Illuminate\Http\Request;

class ResponsavelController extends Controller
{
    private $responsavelRepo;
    private $dependenteRepo;

    public function __construct(){
        $this->responsavelRepo = new Responsavel();
        $this->dependenteRepo = new Dependente();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("dad.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estabelecimentos = Estabelecimento::orderBy('nome', 'desc')->get();

        return view("dad.create", compact("estabelecimentos"));
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
            'nome' => 'required|string|max:200',
            'email' => 'required|email|unique:users,email',
            'idEstabelecimento' => 'required|exists:estabelecimentos,id',
            'senha' => 'required|confirmed',
        ], [
            'nome.required' => 'Favor informar seu nome.',
            'email.required' => 'Favor informar seu e-mail.',
            'email.email' => 'E-mail inválido.',
            'email.unique' => 'E-mail já cadastrado.',
            'idEstabelecimento.required' => 'Favor informar a instituição de ensino.',
            'idEstabelecimento.exists' => 'Instituição de ensino não cadastrado',
            'senha.required' => 'Favor informar uma senha.',
            'senha.confirmed' => 'Favor confirmar a senha.'
        ]);

        $model = $this->responsavelRepo->cadastrar($request);

        return redirect('dad');
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
    public function edit(Responsavel $responsavel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Responsavel  $responsavel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Responsavel $responsavel)
    {
        //
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

    public function verCompras($idDependente = 0)
    {

        $filhos = $this->dependenteRepo->getByResponsavel($this->getIdResponsavel());

        if(!$idDependente) {

            $dependente = $filhos[0];
            $pedidos = $this->dependenteRepo->getPedidos($dependente->id);
            

            return view('dad.childs.history', compact('filhos', 'dependente', 'pedidos'));
        }

        $dependente = $this->dependenteRepo->getById($idDependente);
        $pedidos = $this->dependenteRepo->getPedidos($dependente->id);
        $idSelecionado = $idDependente;

        return view('dad.childs.history', compact('filhos', 'dependente', 'pedidos', 'idSelecionado'));
    }
}
