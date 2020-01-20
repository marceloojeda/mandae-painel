<!-- Modal -->
<div class="modal" tabindex="-1" role="dialog" id="confirmaPedido">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
            Confirmação do pedido
            <small class="d-flex">Digite o número do pedido e clique em buscar</small>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <div class="input-group">
                    <input type="number" id="numero" class="form-control" placeholder="Número do pedido">
                    <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button" onclick="buscarPedido()">Buscar!</button>
                    </span>
                </div>
            </div>
        </div>
        
        <div class="card mt-4 p-2 d-none" id="dadosPedido">
            <div class="card-block">
                <h4 class="card-title" id="title"></h4>
                <h6 class="card-subtitle" id="nome"></h6>

                <input type="hidden" id="idPedido" value="">
            </div>

            <div class="card-block mt-4">
                <ul class="list-group list-group-flush" id="itens">
                </ul>

                <div class="text-center">
                    <h3 class="text-primary mt-4" id="total"></h3>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" id="btnConfirmar" class="btn btn-primary" disabled onclick="confirmarPedido()">Confirmar</button>
      </div>
    </div>
  </div>
</div>


{{-- Modal de confirmação de cancelamento --}}
<div class="modal" tabindex="-1" role="dialog" id="modalConfirmaCancelamento">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirmação</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="pedidoSelecionado">
        <p>Você confirma o cancelamento desse pedido?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="cancelarPedido()">Sim</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
      </div>
    </div>
  </div>
</div>