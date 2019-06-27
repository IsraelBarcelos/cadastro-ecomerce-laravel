<?php

use Illuminate\Http\Request;


// REQUESTS PRODUTO
Route::get('/produtos','ControladorProduto@index');

Route::post('/produtos','ControladorProduto@store');

Route::get('/produtos/editar/{id}','ControladorProduto@show');

Route::PUT('/produtos/{id}','ControladorProduto@update');

Route::DELETE('/produtos/{id}','ControladorProduto@destroy');

Route::PUT('/produtos/reestruturar/{id}','ControladorProduto@reestruturar');

Route::PUT('/produtos/desestruturar/{id}','ControladorProduto@desestruturar');


// REQUESTS CATEGORIA

Route::get('/categorias','ControladorCategoria@index');

Route::post('/categorias','ControladorCategoria@store');

Route::get('/categorias/editar/{id}','ControladorCategoria@show');

Route::PUT('/categorias/{id}','ControladorCategoria@update');

Route::DELETE('/categorias/{id}','ControladorCategoria@destroy');

Route::PUT('/categorias/reestruturar/{id}','ControladorCategoria@reestruturar');

Route::PUT('/categorias/desestruturar/{id}','ControladorCategoria@desestruturar');