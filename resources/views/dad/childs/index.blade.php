@extends('layouts.dad-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dependentes cadastrados</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="d-flex float-right mb-2">
                        <a href="/dad/childs/create" class="btn btn-success">
                            <i class="fa fa-close"></i>
                            Novo Dependente
                        </a>
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th> #</th>
                                <th> Nome</th>
                                <th class="text-center"> Telefone</th>
                                <th> Série</th>
                                <th class="text-center"> Nascimento</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$dependentes)
                                <tr>
                                    <td colspan="6" class="text-center">nenhum dependente cadastrado</td>
                                </tr>
                            @else
                                @foreach($dependentes as $child)
                                    <tr onclick="openForm({{ $child->id }}, 'dependente')" style="cursor: pointer">
                                        <td> {{ $child->id }} </td>
                                        <td> {{ $child->nome }} </td>
                                        <td class="text-center"> {{ \App\Helpers\Formatacao::formataCelular($child->telefone) }} </td>
                                        <td> {{ $child->serie }} </td>
                                        <td class="text-center"> {{ \App\Helpers\Formatacao::toDateBr($child->data_nascimento) }} </td>
                                        <td class="text-right">
                                        <a class="btn btn-secondary btn-sm" href="/dad/childs/{{ $child->id }}">Alterar</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection