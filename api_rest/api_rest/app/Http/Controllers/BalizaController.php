<?php
namespace App\Http\Controllers;

use App\Models\Baliza;
use Illuminate\Http\Request;

class BalizaController extends Controller
{
    public static function procesarDatos($datos){

    }


    //Devuelve todas las balizas
    public function index(){
        return Baliza::all();
    }

    //Muestra una baliza
    public function show(Baliza $baliza){
        return $baliza;
    }

    //Almacena una baliza
    public function store(Request $request){
        $baliza = Baliza::create($request->all());
        return response()->json($baliza,201);
    }

    //Cambia los datos de una baliza por otra
    public function update(Request $request, Baliza $baliza){
        $baliza->update($request->all());
        return response()->json($baliza);
    }

    //Elimina una baliza de la base de datos
    public function delete(Baliza $baliza){
        $baliza->delete();
        return response()->json(null,204);
    }
}
