<?php

namespace App\Http\Controllers\Dad;

use App\Responsavel;
use App\Estabelecimento;
use App\Dependente;
use App\Lancamento;
use App\AsaasTransacao;
use FiltroViewModel;
use Illuminate\Http\Request;

class ResponsavelController extends Controller
{
    private $responsavelRepo;
    private $dependenteRepo;
    private $lancamentoRepo;

    public function __construct(){
        $this->responsavelRepo = new Responsavel();
        $this->dependenteRepo = new Dependente();
        $this->lancamentoRepo = new Lancamento();
    }


    public function index()
    {

        $responsavel = $this->responsavelRepo->getById($this->getIdResponsavel());

        return view("dad.index", compact('responsavel'));
    }

    public function create(Request $request)
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

        return redirect('/dad');
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
    public function edit($id, Request $request)
    {
        
        $id = $this->getIdResponsavel();
        $responsavel = $this->responsavelRepo->getById($id);

        $usuario = Auth()->user();

        return view('dad.edit', compact('responsavel', 'usuario'));
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
        $this->responsavelRepo->atualizar($id, $request);

        return redirect('/dad');
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

    public function extratoFinanceiro(Request $request) {

        $filtroVM = new FiltroViewModel();
        $filtroVM->idEstabelecimento = $this->getIdEstabelecimento();

        $lancamentos = $this->lancamentoRepo->extrato($filtroVM);

        
    }

    public function comprar(Request $request) {

        $responsavel = $this->responsavelRepo->getById($this->getIdResponsavel());

        //redireciona responsavel para completar cadastro
        if(empty($responsavel->cpf)
            || empty($responsavel->rua)
            || empty($responsavel->numero)
            || empty($responsavel->cep)
        ) {
            $request->session()->flash('complete_cad_responsavel', 'Para realizar compras pelo site, você deve completar seu cadastro');

            return redirect('dad/' . $this->getIdResponsavel());
        }

        $filhos = $this->dependenteRepo->getByResponsavel($this->getIdResponsavel());
        $dependentes = [];
        foreach ($filhos as $filho) {

            $nomePartes = explode(' ', $filho->nome);
            $dependentes[] = array(
                'id' => $filho->id,
                'nome' => $filho->nome,
                'saudacao' => $nomePartes[0],
                'serie' => $filho->serie,
                'saldo' => $filho->conta->saldo
            );
        }
        $saldo = $dependentes ? $dependentes[0]['saldo'] : 0;

        $user = Auth()->user();

        $responsavel->email = $user->email;

        return view('dad.comprar', compact('dependentes', 'saldo', 'responsavel'));
    }

    public function confirmaSolicitacaoCompra(Request $request) {

        $model = AsaasTransacao::create($request->except('fine', 'interest', 'discount'));

        $this->responsavelRepo->updateAsaasCustomer($request->customer, $this->getIdResponsavel());

        return response()->json($model);
    }
}
