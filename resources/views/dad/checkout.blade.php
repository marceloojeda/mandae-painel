@extends('layouts.dad-app')

@section('content')

<input type="hidden" id="valor" value="{{ $valor }}">
<input type="hidden" id="taxa" value="{{ $taxa }}">
<input type="hidden" id="idDependente" value="{{ $dependente->id }}">

<div class="row p-4" id="form-confirmacao">
    <div class="card col-6 offset-3">
        <div class="card-block p-4">
            <h4 class="card-title">Resumo da compra</h4>
            <h6 class="card-subtitle mb-2 text-muted">Confira os itens do carrinho e escolha a forma de pagamento</h6>
        </div>
        <div class="card-block">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    {{ \App\Helpers\Formatacao::somenteNumeros($valor) }} reais em créditos
                    <span class="badge badge-info float-right">{{ \App\Helpers\Formatacao::formataNumero($valor) }}</span>
                </li>
                <li class="list-group-item">
                    Taxa administrativa
                    <span class="badge badge-info float-right">{{ \App\Helpers\Formatacao::formataNumero($taxa) }}</span>
                </li>
                <li class="list-group-item">
                    
                    <span class="badge float-right text-muted">Total: R$ {{ \App\Helpers\Formatacao::formataNumero($total) }}</span>
                </li>
            </ul>
        </div>

        <div class="card-footer text-center">
            <button class="btn btn-primary mr-2" type="button" onclick="confirmaCompra('boleto')">
                <span class="fa fa-barcode"></span> Pagar com boleto
            </button>

            <button class="btn btn-primary" type="button" onclick="confirmaCompra('cartao')">
                <span class="fa fa-credit-card"></span> Pagar com cartão de crédito/débito
            </button>

            <p class="mt-4 text-left text-muted">
                <b>Atenção:</b> Ao confirmar a compra, você será direcionado para o site da <a href="https://https://www.asaas.com/">Asaas</a>, nosso parceiro comercial responsável pelos recebimentos online.
            </p>
        </div>
    </div>
</div>

<div class="row p-4 d-none" id="pos-confirmacao">
    <div class="card col-6 offset-3">
        <div class="card-block p-4">
            <h4 class="card-title">Compra confirmada!</h4>
            <h6 class="card-subtitle mb-2 text-muted">Enviamos pra você um e-mail com as informações dessa compra.</h6>
        </div>
        <div class="card-block">
            <p class="mt-4 text-left text-muted">
                Assim que recebermos a confirmação de pagamento, pela <a href="https://https://www.asaas.com/">Asaas</a>, seus créditos serão creditados, ;).
            </p>
        </div>
    </div>
</div>

@endsection