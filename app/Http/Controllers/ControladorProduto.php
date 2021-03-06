<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;

class ControladorProduto extends Controller
{

    public function index()
    {
        $produtos = Produto::with(['categorias'])->get();
        if(count($produtos) > 0){
            return $produtos->toJson();
        }
        return response("Não há produtos : O servidor deve estar fora do ar.",404);
    }


    public function store(Request $request)
    {
        $produto = new Produto();
        $produto->produto = $request->input('produto');
        $produto->valor = $request->input('valor');
        $produto->estoque = $request->input('estoque');
        $produto->save();

        $produtoComcategorias = Produto::where('id',$produto->id)->with(['categorias'])->first();
        
        if(isset($produto)){
            return json_encode($produtoComcategorias);
        }

        return response('Produto não encontrado',404);
    }


    public function show($id)
    {
        $produto = Produto::where('id',$id)->with('categorias')->first();
        if(isset($produto)){
            return json_encode($produto);
        }

        return response('Produto não encontrado',404);
    }

    public function update(Request $request, $id)
    {
        $produto = Produto::where('id',$id)->first();
        $produto->produto = $request->input('produto');
        $produto->estoque = $request->input('estoque');
        $produto->valor = $request->input('valor');
        $produto->save();
        $produto = Produto::where('id',$id)->with(['categorias'])->first();
        
        if(isset($produto)){
            return json_encode($produto);
        }

        return response('Produto não encontrado',404);

    }

    public function destroy($id)
    {
        $produto = Produto::where('id',$id)->first();
        
        if(isset($produto)){
            $produto->delete();
            return json_encode($produto);
        }
        return response('Produto não encontrado',404);
    }

    public function reestruturar(Request $request, $id){
        $prod = Produto::where('id',$id)->with('categorias')->first(); //recebe o produto

        
        if(isset($prod)){ // se ele existir

            $cats = $request->input('idscategorias');
            foreach($cats as $c){
                if($c == ""){
                    unset($c);
                }
            }
            $prod->categorias()->detach();
            $prod->categorias()->attach($cats);
            $prod = Produto::where('id',$id)->with('categorias')->first();
            return json_encode($prod);
        }
        return response('Pagina foi descontinuada, atualizar para receber novas informações',404);        
    }

}
