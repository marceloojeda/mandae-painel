@extends('layouts.canteen-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Pedidos confirmados</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th> #</th>
                                <th> Aluno</th>
                                <th> Série</th>
                                <th> Data</th>
                                <th class="text-right"> Total</th>
                                <th> </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!count($pedidos))
                                <tr>
                                    <td colspan="6" class="text-center">nenhum pedido pra mostrar</td>
                                </tr>
                            @else
                                @foreach($pedidos as $pedido)
                                    <tr onclick="selectPedido({{ $pedido->idPedido }})" style="cursor: pointer">
                                        <td> {{ $pedido->pedido }} </td>
                                        <td> {{ $pedido->aluno }} </td>
                                        <td> {{ $pedido->serie }} </td>
                                        <td> {{ \App\Helpers\Formatacao::toDateBrHr($pedido->data) }} </td>
                                        <td class="text-right"> {{ \App\Helpers\Formatacao::formataNumero($pedido->total) }} </td>
                                        <td class="text-right">
                                            <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modalConfirmaCancelamento">
                                                Estornar
                                            </button>
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

@include('canteen.pedidos.estorna')
@endsection