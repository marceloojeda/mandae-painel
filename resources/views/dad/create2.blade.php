@extends('layouts.dad-app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Cadastro do responsável</div>

                <form action="/dad" method="POST">
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
                                <div class="col-6 mb-2">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" name="nome" value="{{ old('nome') }}">
                                </div>

                                <div class="col-6 mb-2">
                                    <label>E-mail</label>
                                    <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                                </div>

                                <div class="col-4 mb-2">
                                    <label>CPF</label>
                                    <input type="text" class="form-control cpf" name="cpf" value="{{ old('cpf') }}">
                                </div>

                                <div class="col-4 mb-2">
                                    <label>Telefone</label>
                                    <input type="text" class="form-control fone-fixo" name="telefone" value="{{ old('telefone') }}">
                                </div>

                                <div class="col-4 mb-2">
                                    <label>Celular</label>
                                    <input type="text" class="form-control celular" name="celular" value="{{ old('celular') }}">
                                </div>

                                <div class="col-4 mb-2">
                                    <label>CEP</label>
                                    <div class="input-group">
                                    <input type="text" name="cep" id="txtCep" class="form-control cep" placeholder="CEP" value="{{ old('cep') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" onclick="buscaCep()">Pesquisar CEP</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4 mb-2">
                                    <label>Endereço</label>
                                    <input type="text" class="form-control" id="rua" name="endereco" value="{{ old('endereco') }}" readonly>
                                </div>

                                <div class="col-4 mb-2">
                                    <label>Bairro</label>
                                    <input type="text" class="form-control" id="bairro" name="bairro" value="{{ old('bairro') }}" readonly>
                                </div>

                                <div class="col-4 mb-2">
                                    <label>Cidade/UF</label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" value="{{ old('cidade') }}" readonly>
                                    <input type="hidden" name="uf" id="uf">
                                </div>

                                <div class="col-4 mb-2">
                                    <label>Número</label>
                                    <input type="text" class="form-control" id="numero" name="numero" value="{{ old('numero') }}">
                                </div>

                                <div class="col-4 mb-2">
                                    <label>Complemento</label>
                                    <input type="text" class="form-control" id="complemento" name="complemento" value="{{ old('complemento') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection