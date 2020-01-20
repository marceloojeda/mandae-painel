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
        <p>Você confirma o estorno desse pedido?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="estornarPedido()">Sim</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
      </div>
    </div>
  </div>
</div>