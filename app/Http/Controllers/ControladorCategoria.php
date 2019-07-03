<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;

class ControladorCategoria extends Controller
{

    public function index()
    {
        $categorias = Categoria::with('produtos')->get();
        if(count($categorias) > 0){
            return $categorias->toJson();
        }
        return response("Não há categorias : O servidor deve estar fora do ar.",404);
    }

    public function store(Request $request)
    {
        $categoria = new Categoria();
        $categoria->categoria = $request->input('categoria');
        $categoria->save();

        if(isset($categoria)){
            return json_encode($categoria);
        }

        return response('categoria não encontrado',404);
    }

    public function show($id)
    {
        $categoria = Categoria::where('id',$id)->with(['produtos'])->first();
        if(isset($categoria)){
            return json_encode($categoria);
        }

        return response('categoria não encontrado',404);
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::where('id',$id)->first();
        $categoria->categoria = $request->input('categoria');
        
        if(isset($categoria)){
            $categoria->save();

            $categoria = Categoria::where('id',$id)->with('produtos')->first();
            return json_encode($categoria);
        }

        return response('categoria não encontrado',404);
    }

 
    public function destroy($id)
    {
        $categoria = Categoria::where('id',$id)->first();
        if(isset($categoria)){
            $categoria->delete();
            return json_encode($categoria);
        }
        return response('categoria não encontrado',404);
    }

    public function reestruturar($id, Request $request){
        $cat = Categoria::where('id',$id)->first();
        
        if(isset($cat)){
            $prods = $request->input('idsprodutos');
            foreach($prods as $p){
                if($p == ""){
                    unset($p);
                }
            }
            $cat->produtos()->detach();
            $cat->produtos()->attach($prods);
            $cat = Categoria::where('id',$id)->with('produtos')->first();
            return json_encode($cat);

        }
        return response('Pagina foi descontinuada, atualizar para receber novas informações',404);        
    }
}

