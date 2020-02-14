<?php

namespace App\Http\Controllers\Canteen;

use Illuminate\Http\Request;
use App\Pedido;
use App\Estabelecimento;
use App\Lancamento;
use App\Helpers\Formatacao;
use Config;

class PedidoController extends Controller
{

    private $pedidosRepo;
    private $lancamentosRepo;
    
    public function __construct()
    {
        $this->middleware('auth');

        $this->pedidosRepo = new Pedido();
        $this->lancamentosRepo = new Lancamento();
    }

    public function listaPedidosAbertos()
    {
        $user = Auth()->user();
        $cantina = Estabelecimento::getByUserId($user->id);

        $pedidos = $this->pedidosRepo->listarPedidosAbertos($cantina->id);

        return view("canteen.pedidos.abertos", compact("pedidos"));
    }

    public function listaPedidosConfirmados()
    {
        $user = Auth()->user();
        $cantina = Estabelecimento::getByUserId($user->id);

        $pedidos = $this->pedidosRepo->listarPedidosConfirmados($cantina->id);

        return view("canteen.pedidos.confirmados", compact("pedidos"));
    }

    public function destroy($id){
        $this->pedidosRepo->atualizarStatus($id, Config::get('constants.STATUS_PEDIDO.CANCELADO'));
    }

    public function estornar($id){

        $resposta = array(
            'erro' => false,
            'msgErro' => ''
        );

        try {
            $pedido = $this->pedidosRepo->getById($id);

            $this->lancamentosRepo->lancarCredito($pedido->estabelecimento_id, $pedido->conta_id, $pedido->total);

            $this->pedidosRepo->atualizarStatus($id, Config::get('constants.STATUS_PEDIDO.CANCELADO'));

        } catch (Exception $e) {
            $resposta['erro'] = true;
            $resposta['msgErro'] = "Não foi possível realizar a baixa do pedido: " . $e->getMessage();
        }
        
        return response()->json($resposta);
    }

    public function buscarPeloNumero($numero){
        $resposta = array(
            'erro' => false,
            'msgErro' => '',
            'pedido' => null,
            'itens' => null,
            'dependente' => null
        );

        try {
            $pedido = $this->pedidosRepo->getByNumero($numero);

            $pedido->total = Formatacao::formataNumero($pedido->total);
            $resposta['pedido'] = $pedido;
            $resposta['dependente'] = $pedido->conta->dependente;

            $itens = [];
            foreach ($pedido->itens as $item) {
                $itens[] = array(
                    'idProduto' => $item->produto_id,
                    'produto' => $item->produto->descricao,
                    'preco' => Formatacao::formataNumero($item->valor_unitario),
                    'quantidade' => $item->quantidade,
                    'total' => Formatacao::formataNumero($item->total)
                );
            }
            
            $resposta['itens'] = $itens;
        } catch (\Exception $e) {
            $resposta['erro'] = true;
            $resposta['msgErro'] = "Nenhum pedido foi encontrado com esse número.";
        }

        return response()->json($resposta);
    }

    public function confirmaPedido($id){
        $resposta = array(
            'erro' => false,
            'msgErro' => ''
        );

        $validacao = $this->pedidosRepo->validarConfirmacao($id);
        if(!empty($validacao)) {

            $resposta['erro'] = true;
            $resposta['msgErro'] = $validacao;

            return response()->json($resposta);
        }

        try {
            $pedido = $this->pedidosRepo->getById($id);

            $this->lancamentosRepo->confirmaCompra($pedido->estabelecimento_id, $pedido->conta_id, $pedido->total);

            $this->pedidosRepo->atualizarStatus($id, Config::get('constants.STATUS_PEDIDO.CONFIRMADO'));

        } catch (Exception $e) {
            
            $resposta['erro'] = true;
            $resposta['msgErro'] = "Não foi possível realizar a baixa do pedido: " . $e->getMessage();
        }
        
        return response()->json($resposta);
    }

    public function extratoFinanceiro(Request $request) {

    }
}
