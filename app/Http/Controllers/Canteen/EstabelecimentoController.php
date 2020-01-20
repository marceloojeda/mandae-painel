<?php

namespace App\Http\Controllers\Canteen;

use App\Estabelecimento;
use Illuminate\Http\Request;

class EstabelecimentoController extends Controller
{
    private $estabelecimentoRepo;


    public function __construct(){
        $this->estabelecimentoRepo = new Estabelecimento();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('canteen.home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('canteen.create');
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
            'email' => 'required|email|unique:estabelecimentos,email',
            'escola' => 'required|string|max:200',
            'senha' => 'required|confirmed',
        ], [
            'nome.required' => 'Favor informar seu nome.',
            'email.required' => 'Favor informar seu e-mail.',
            'email.email' => 'E-mail inválido.',
            'email.unique' => 'E-mail já cadastrado.',
            'escola.required' => 'Favor informar o nome da instituição de ensino.',
            'senha.required' => 'Favor informar uma senha.',
            'senha.confirmed' => 'Favor confirmar a senha.'
        ]);

        $arrInsert = $request->except(['_token', 'senha_confirmation']);

        $model = $this->estabelecimentoRepo->cadastrar($arrInsert);

        return redirect('canteen');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
