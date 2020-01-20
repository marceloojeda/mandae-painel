@extends('layouts.dad-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Altera dependente</div>

                <form action="/dad/childs/{{ $dependente->id }}" method="POST">
                    @csrf
                    @method('put')
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
                                    <input type="text" class="form-control" name="nome" value="{{ $dependente->nome }}">
                                </div>

                                <div class="col-6 mb-2">
                                    <label>Série</label>
                                    <input type="text" class="form-control" name="serie" value="{{ $dependente->serie }}">
                                </div>

                                <div class="col-4 mb-2">
                                    <label>Nascimento</label>
                                    <input type="text" class="form-control" name="dataNascimento" value="{{ \App\Helpers\Formatacao::toDateBr($dependente->data_nascimento) }}">
                                </div>

                                <div class="col-4 mb-2">
                                    <label>Telefone</label>
                                    <input type="text" class="form-control" name="telefone" value="{{ \App\Helpers\Formatacao::formataCelular($dependente->telefone) }}">
                                </div>

                                <div class="col-4 mb-2">
                                    <label>Senha</label>
                                    <input type="password" class="form-control" name="senha" value="">
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