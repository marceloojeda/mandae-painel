@extends('layouts.dad-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Histórico dos pedidos</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (count($filhos) > 1)
                        <div class="col-5 float-right mb-2">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Dependente: </span>
                                <select name="dependente" id="selDependente" class="form-control" aria-describedby="basic-addon1">
                                    @foreach ($filhos as $filho)
                                        @if (isset($idSelecionado) && $idSelecionado == $filho->id)
                                            <option value="{{ $filho->id }}" selected>{{ $filho->nome }}</option>
                                        @else
                                            <option value="{{ $filho->id }}">{{ $filho->nome }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th> #</th>
                                <th> Data</th>
                                <th> Dependente</th>
                                <th class="text-center"> Valor</th>
                                <th> Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!count($pedidos))
                                <tr>
                                    <td colspan="6" class="text-center">nenhum pedido de compra cadastrado</td>
                                </tr>
                            @else
                                @foreach($pedidos as $pedido)
                                    <tr style="cursor: pointer">
                                        <td> {{ $pedido->numero_pedido }} </td>
                                        <td> {{ \App\Helpers\Formatacao::toDateBrHr($pedido->created_at) }} </td>
                                        <td> {{ $dependente->nome }} </td>
                                        <td class="text-center"> {{ \App\Helpers\Formatacao::formataNumero($pedido->total) }} </td>
                                        <td> {{ $pedido->status }} </td>
                                        <td class="text-right">
                                            <a class="btn btn-info btn-sm" href="#" onclick="openModal({{ $pedido->id }}, 'pedido')">Ver Detalhes</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr class=text-center>
                                <th colspan="6">
                                    {{ $pedidos->links() }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('dad/childs/pedido-detalhe')
@endsection