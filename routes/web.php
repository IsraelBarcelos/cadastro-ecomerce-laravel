<?php



Route::get('/', function () {
    return view('index');
});

Route::get('/categorias', function(){
	return view('categorias');
});

Route::get('/produtos', function(){
	return view('produtos');
});
