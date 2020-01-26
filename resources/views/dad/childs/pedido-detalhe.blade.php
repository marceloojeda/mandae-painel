<!-- Modal -->
<div class="modal" tabindex="-1" role="dialog" id="detalhePedido">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detalhes do pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="form-group col-3">
                <label>Número</label>
                <input type="text" class="form-control" id="numero" readonly>
            </div>

            <div class="form-group col-4">
                <label>Data</label>
                <input type="text" class="form-control" id="data" readonly>
            </div>

            <div class="form-group col-5">
                <label>Situação</label>
                <input type="text" class="form-control" id="situacao" readonly>
            </div>

            <div class="form-group col-6">
                <label>Dependente</label>
                <input type="text" class="form-control" id="dependente" readonly>
            </div>

            <div class="form-group col-6">
                <label>Série</label>
                <input type="text" class="form-control" id="serie" readonly>
            </div>
        </div>

        <table class="table" id="tabItens">
            <thead>
                <th>Qtdade</th>
                <th>Produto</th>
                <th class="text-right">Valor Unitário</th>
                <th class="text-right">Total do item</th>
            </thead>
            <tbody></tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        {{-- <button type="button" class="btn btn-primary" onclick="cadastrarCategoria()">Salvar</button> --}}
      </div>
    </div>
  </div>
</div>