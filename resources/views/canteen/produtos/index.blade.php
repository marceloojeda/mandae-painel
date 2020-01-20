@extends('layouts.canteen-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Produtos cadastrados</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="d-flex float-right mb-2">
                        <a href="cardapio/create" class="btn btn-success">
                            <i class="fa fa-close"></i>
                            Novo Produto
                        </a>
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th> #</th>
                                <th> Descrição</th>
                                <th class="text-right"> Custo</th>
                                <th class="text-center"> Ativo</th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$produtos->total())
                                <tr>
                                    <td colspan="4" class="text-center">nenhum produto cadastrado</td>
                                </tr>
                            @else
                                @foreach($produtos as $produto)
                                    <tr onclick="openForm({{ $produto->id }}, 'produto')" style="cursor: pointer">
                                        <td> {{ $produto->id }} </td>
                                        <td> {{ $produto->descricao }} </td>
                                        <td class="text-right"> {{ \App\Helpers\Formatacao::formataNumero($produto->preco_venda, 2) }} </td>
                                        <td class="text-center"> {{ $produto->ativo ? 'Sim' : 'Não' }} </td>
                                        <td class="text-right">
                                        <a class="btn btn-secondary btn-sm" href="/canteen/cardapio/{{ $produto->id }}">Alterar</a>
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