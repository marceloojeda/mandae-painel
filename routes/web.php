<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/dad/create', 'Dad\ResponsavelController@create')->middleware('auth');

Route::namespace('Canteen')->group(function () {
    
    Route::get('/canteen', 'EstabelecimentoController@index');
    Route::get('/canteen/create', 'EstabelecimentoController@create');
    Route::post('/canteen', 'EstabelecimentoController@store');

    Route::get('/canteen/cardapio', 'ProdutoController@index')->middleware('auth');
    Route::get('/canteen/cardapio/create', 'ProdutoController@create')->middleware('auth');
    Route::get('/canteen/cardapio/{id}', 'ProdutoController@edit')->middleware('auth');
    Route::post('/canteen/cardapio', 'ProdutoController@store')->middleware('auth');
    Route::put('/canteen/cardapio/{id}', 'ProdutoController@update')->middleware('auth');
    Route::post('/canteen/cardapio/categoria', 'ProdutoController@cadastrarCategoria')->middleware('auth');

    Route::get('/canteen/pedidos/abertos', 'PedidoController@listaPedidosAbertos')->middleware('auth');
    Route::get('/canteen/pedidos/confirmados', 'PedidoController@listaPedidosConfirmados')->middleware('auth');
    Route::get('/canteen/pedidos/cancelar/{id}', 'PedidoController@destroy')->name('pedidos.cancelar')->middleware('auth');
    Route::get('/canteen/pedidos/estornar/{id}', 'PedidoController@estornar')->name('pedidos.estornar')->middleware('auth');
    Route::get('/canteen/pedidos/buscar-pedido/{numero}', 'PedidoController@buscarPeloNumero')->middleware('auth');
    Route::get('/canteen/pedidos/confirma-pedido/{id}', 'PedidoController@confirmaPedido')->middleware('auth');
});

Route::namespace('Dad')->group(function () {
    Route::get('/dad', 'ResponsavelController@index')->middleware('auth');
    Route::get('/dad/create', 'ResponsavelController@create');
    Route::get('/dad/shopping/{idDependente}', 'ResponsavelController@verCompras');
    Route::get('/dad/credits', 'ResponsavelController@comprar');
    Route::get('/dad/childs', 'DependenteController@index')->middleware('auth');
    Route::get('/dad/childs/create', 'DependenteController@create')->middleware('auth');
    Route::get('/dad/childs/{id}', 'DependenteController@edit')->middleware('auth');
    Route::get('/dad/{id}', 'ResponsavelController@edit')->name('dad.edit')->middleware('auth');

    Route::post('/dad', 'ResponsavelController@store');
    Route::put('/dad/{id}', 'ResponsavelController@update');

    Route::post('/dad/childs', 'DependenteController@store')->middleware('auth');
    Route::put('/dad/childs/{id}', 'DependenteController@update')->middleware('auth');

    // endpoints usados pelo app, pelo dependente
    Route::get('/dad/childs/pedidos/{id}', 'DependenteController@showPedido');

    // endpoints relacionados à compra de creditos
    Route::post('/dad/sale', 'ResponsavelController@confirmaSolicitacaoCompra');

    // saldo do dependente
    Route::get('/dad/conta/{idDependente}', 'DependenteController@getConta')->middleware('auth');
});