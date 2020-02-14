@extends('layouts.dad-app')

@section('content')

<div class="container">
    <div class="jumbotron col-12">
        <h1>Olá {{ explode(' ', $responsavel->nome)[0] }},</h1>
        <p class="lead">
            Esse é seu Painel de Controle do iCantina. Aqui você pode acompanhar a qualidade dos lanches do seu filho na lanchonete escolar, 
            e também ver e controlar essas despesas.
        </p>
    </div>
</div>

<div id="chart_div_google_user_count"></div>
@include('dad.widget_partial')
@endsection