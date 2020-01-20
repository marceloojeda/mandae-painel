@extends('layouts.canteen-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Novo produto</div>

                <form action="/canteen/cardapio" method="POST">
                    @csrf
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex float-right mb-2">
                                    
                                    <button type="submit" class="btn btn-primary ml-2">
                                        <i class="fa fa-close"></i>
                                        Salvar
                                    </button>
                                    <a href="canteen/cardapio" class="btn btn-secondary ml-2">
                                        <i class="fa fa-close"></i>
                                        Voltar
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group">
                            <div class="row">
                                <div class="col-8 mb-2">
                                    <label>Descrição do produto</label>
                                    <input type="text" class="form-control" name="descricao" value="{{ old('descricao') }}">
                                </div>

                                <div class="col-4 mb-2">
                                    <label>Preço venda</label>
                                    <input type="text" class="form-control" name="preco" value="{{ old('preco') }}">
                                </div>

                                <div class="col-8 mb-2">
                                    <label>Categoria</label>
                                    <div class="input-group">
                                        <select class="custom-select" name="idCategoria" id="selectCategoria">
                                            <option selected disabled>Selecione uma categoria</option>
                                            @foreach ($categorias as $categoria)
                                                <option value="{{ $categoria->id }}">{{ $categoria->descricao }}</option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="btnNovaCategoria">Novo</button>
                                        </div>
                                    </div>
                                </div>

                                

                                <div class="col-4 mb-2">
                                    <label>Status</label>
                                    <div class="form-check pl-0">
                                        <input id="checkStatus" name="ativo" class="form-control mb-2" type="checkbox" checked data-toggle="toggle" data-on="Ativo" data-off="Inativo" data-onstyle="primary" data-offstyle="secondary">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal" tabindex="-1" role="dialog" id="createCategoria">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nova categoria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group col-12">
            <label>Descrição da categoria</label>
            <input type="text" class="form-control" id="categoria">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary" onclick="cadastrarCategoria()">Salvar</button>
      </div>
    </div>
  </div>
</div>

@endsection