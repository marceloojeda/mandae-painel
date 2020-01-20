<?php

namespace App\Http\Controllers\Dad;

use App\Dependente;
use App\Responsavel;
use App\Estabelecimento;
use Illuminate\Http\Request;

class DependenteController extends Controller
{
    private $dependenteRepo;

    public function __construct(){
        $this->dependenteRepo = new Dependente();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dependentes = $this->dependenteRepo->getByResponsavel($this->getIdResponsavel());
        return view("dad.childs.index", compact("dependentes"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $responsavel = Responsavel::where('id', $this->getIdResponsavel())->firstOrFail();

        return view("dad.childs.create", compact("responsavel"));
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
            'dataNascimento' => 'required',
            'telefone' => 'required|max:20',
            'senha' => 'required',
        ], [
            'nome.required' => 'Favor informar o nome.',
            'dataNascimento.required' => 'Favor informar a data de nascimento.',
            'telefone.required' => 'Favor informar o número de telefone.',
            'telefone.max' => 'Formato de telefone inválido.',
            'senha.required' => 'Favor informar uma senha.'
        ]);

        $request->idResponsavel = $this->getIdResponsavel();
        $request->idEstabelecimento = $this->getIdEstabelecimento();

        $model = $this->dependenteRepo->cadastrar($request);

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
    public function edit($id)
    {
        $dependente = $this->dependenteRepo->getById($id);

        return view("dad.childs.edit", compact("dependente"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Responsavel  $responsavel
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:200',
            'dataNascimento' => 'required',
            'telefone' => 'required|max:20'
        ], [
            'nome.required' => 'Favor informar o nome.',
            'dataNascimento.required' => 'Favor informar a data de nascimento.',
            'telefone.required' => 'Favor informar o número de telefone.',
            'telefone.max' => 'Formato de telefone inválido.'
        ]);

        $request->id = $id;

        $model = $this->dependenteRepo->atualizar($request);

        return redirect('dad');
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

    public function login(Request $request){
        
    }
}
