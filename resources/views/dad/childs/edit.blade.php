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
                                <div class="col-6 mb-4">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" name="nome" value="{{ $dependente->nome }}">
                                </div>

                                <div class="col-6 mb-4">
                                    <label>Série</label>
                                    <select name="serie" id="selSerie" class="form-control">
                                        <option disabled>Selecione</option>
                                        <option value="Educação infantil" {{ $dependente->serie == 'Educação infantil' ? 'selected' : '' }}>Educação infantil</option>
                                        <option value="1º ano do ens. fundamental I" {{ $dependente->serie == '1º ano do ens. fundamental I' ? 'selected' : '' }}>1º ano do ens. fundamental I</option>
                                        <option value="2º ano do ens. fundamental I" {{ $dependente->serie == '2º ano do ens. fundamental I' ? 'selected' : '' }}>2º ano do ens. fundamental I</option>
                                        <option value="3º ano do ens. fundamental I" {{ $dependente->serie == '3º ano do ens. fundamental I' ? 'selected' : '' }}>3º ano do ens. fundamental I</option>
                                        <option value="4º ano do ens. fundamental I" {{ $dependente->serie == '4º ano do ens. fundamental I' ? 'selected' : '' }}>4º ano do ens. fundamental I</option>
                                        <option value="5º ano do ens. fundamental I" {{ $dependente->serie == '5º ano do ens. fundamental I' ? 'selected' : '' }}>5º ano do ens. fundamental I</option>
                                        <option value="6º ano do ens. fundamental II" {{ $dependente->serie == '6º ano do ens. fundamental II' ? 'selected' : '' }}>6º ano do ens. fundamental II</option>
                                        <option value="7º ano do ens. fundamental II" {{ $dependente->serie == '7º ano do ens. fundamental II' ? 'selected' : '' }}>7º ano do ens. fundamental II</option>
                                        <option value="8º ano do ens. fundamental II" {{ $dependente->serie == '8º ano do ens. fundamental II' ? 'selected' : '' }}>8º ano do ens. fundamental II</option>
                                        <option value="9º ano do ens. fundamental II" {{ $dependente->serie == '9º ano do ens. fundamental II' ? 'selected' : '' }}>9º ano do ens. fundamental II</option>
                                        <option value="1º ano do ens. médio" {{ $dependente->serie == '1º ano do ens. médio' ? 'selected' : '' }}>1º ano do ens. médio</option>
                                        <option value="2º ano do ens. médio" {{ $dependente->serie == '2º ano do ens. médio' ? 'selected' : '' }}>2º ano do ens. médio</option>
                                        <option value="3º ano do ens. médio" {{ $dependente->serie == '3º ano do ens. médio' ? 'selected' : '' }}>3º ano do ens. médio</option>
                                    </select>
                                </div>

                                <div class="col-6 mb-4">
                                    <label>Nascimento</label>
                                    <input type="text" class="form-control" name="dataNascimento" value="{{ \App\Helpers\Formatacao::toDateBr($dependente->data_nascimento) }}">
                                </div>

                                <div class="col-6 mb-4">
                                    <label>Telefone</label>
                                    <input type="text" class="form-control" name="telefone" value="{{ \App\Helpers\Formatacao::formataCelular($dependente->telefone) }}">
                                </div>

                                <div class="col-6 mb-4">
                                    <label>Limite diário*</label>
                                    <input type="text" class="form-control money2" name="limite" value="{{ \App\Helpers\Formatacao::formataNumero($dependente->limite) }}">
                                </div>

                                <div class="col-6 mb-4">
                                    <label>Senha do aplicativo**</label>
                                    <input type="text" class="form-control" name="senha" value="{{ $dependente->senha }}">
                                </div>
                            </div>
                            <p>
                                <em>* se este campo for vazio, o dependente poderá gastar quantos quiser por dia.</em>
                                <br>
                                <em>** senha usada pelo dependente para acessar o aplicativo iCantina.</em>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection