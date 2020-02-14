@extends('layouts.dad-app')

@section('content')

@if (count($dependentes) > 1)
<div class="row">
    <div class="col-md-6 offset-md-3">
        <table class="table">
            <thead class="thead-dark">
                <th>Pra quem vai o crédito ?</th>
                <th class="text-right">Saldo atual</th>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select class="form-control" id="compra-selDependente" onchange="getSaldo()">
                            @foreach ($dependentes as $filho)
                                <option value="{{ $filho['id'] }}">{{ $filho['nome'] }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="text-right">
                        <label id="saldo">R$ {{ \App\Helpers\Formatacao::formataNumero($saldo) }}</label>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endif

<div class="row p-4">

        <div class="col-4">
            <div class="card" style="width: 20rem;">
                <img class="card-img-top img-credito pt-2" src="{{ asset('img/credJet.png') }}" alt="Card image cap">
                <div class="card-block text-center">
                    <h4 class="card-title mt-2">Rápidão</h4>
                    <p class="card-text">30 reais em créditos <br><small>3 a 4 dias de lanche</small></p>
                </div>
                <div class="card-block text-center mt-4 pt-2 pb-2 bg-botao-comprar" style="width: 100%">
                    <button class="btn btn-success" type="button" onclick="comprar(30.00, 3.00)">
                        <span class="fa fa-cart-arrow-down"></span> Comprar
                    </button>
                </div>
            </div>
        </div>
    
        <div class="col-4">
            <div class="card" style="width: 20rem;">
                <img class="card-img-top img-credito pt-2" src="{{ asset('img/credJet.png') }}" alt="Card image cap">
                <div class="card-block text-center">
                    <h4 class="card-title mt-2">Semanal</h4>
                    <p class="card-text">50 reais em créditos <br><small>uma semana de lanche</small></p>
                </div>
                <div class="card-block text-center mt-4 pt-2 pb-2 bg-botao-comprar">
                    <button class="btn btn-success" type="button" onclick="comprar(50.00, 3.00)">
                        <span class="fa fa-cart-arrow-down"></span> Comprar
                    </button>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card" style="width: 20rem;">
                <img class="card-img-top img-credito pt-2" src="{{ asset('img/credJet.png') }}" alt="Card image cap">
                <div class="card-block text-center">
                    <h4 class="card-title mt-2">Quinzenal</h4>
                    <p class="card-text">100 reais em créditos <br><small>duas semanas de lanche</small></p>
                </div>
                <div class="card-block text-center mt-4 pt-2 pb-2 bg-botao-comprar">
                    <button class="btn btn-success" type="button" onclick="comprar(100.00, 5)">
                        <span class="fa fa-cart-arrow-down"></span> Comprar
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- 2ª LINHA --}}
    <div class="row p-4">
        <div class="col-4">
            <div class="card" style="width: 20rem;">
                <img class="card-img-top img-credito pt-2" src="{{ asset('img/credJet.png') }}" alt="Card image cap">
                <div class="card-block text-center">
                    <h4 class="card-title mt-2">Mensal</h4>
                    <p class="card-text">200 reais em créditos <br><small>um mês de lanche</small></p>
                </div>
                <div class="card-block text-center mt-4 pt-2 pb-2 bg-botao-comprar">
                    <button class="btn btn-success" type="button" onclick="comprar(30.00, 8.00)">
                        <span class="fa fa-cart-arrow-down"></span> Comprar
                    </button>
                </div>
            </div>
        </div>
    
        <div class="col-4">
            <div class="card" style="width: 20rem;">
                <img class="card-img-top img-credito pt-2" src="{{ asset('img/credJet.png') }}" alt="Card image cap">
                <div class="card-block text-center">
                    <h4 class="card-title mt-2">Extra</h4>
                    <p class="card-text">300 reais em créditos <br><small>dois filhos na mesma escola?</small></p>
                </div>
                <div class="card-block text-center mt-4 pt-2 pb-2 bg-botao-comprar">
                    <button class="btn btn-success" type="button" onclick="comprar(30.00, 10.50)">
                        <span class="fa fa-cart-arrow-down"></span> Comprar
                    </button>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card" style="width: 20rem;">
                <img class="card-img-top img-credito pt-2" src="{{ asset('img/credJet.png') }}" alt="Card image cap">
                <div class="card-block text-center">
                    <h4 class="card-title mt-2">Super</h4>
                    <p class="card-text">400 reais em créditos <br><small>lanche garantido pra turma toda.. ;)</small></p>
                </div>
                <div class="card-block text-center mt-4 pt-2 pb-2 bg-botao-comprar">
                    <button class="btn btn-success" type="button" onclick="comprar(30.00, 11.56)">
                        <span class="fa fa-cart-arrow-down"></span> Comprar
                    </button>
                </div>
            </div>
        </div>
    
</div>

@endsection