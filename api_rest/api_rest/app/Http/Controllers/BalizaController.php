<?php
namespace App\Http\Controllers;

use App\Models\Baliza;
use Illuminate\Http\Request;

class BalizaController extends Controller
{
    public static function procesarDatos($nombre, $datos){
            $counter = 0; //Aqui vamos a almacenar donde está el dato más nuevo que no sea null
            $minutos = 0; //Aquí vamos a almacenar el minuto del dia al que pertenece la última lectura
            for($i =0;$i<count($datos);$i++){
                if(is_null($datos[$i][1])){
                    $counter = $i-1;
                    $minutos = $counter * 10;
                    $i = count($datos);
                }
            }
            $ultimoDato = $datos[$counter];//Almacenamos el último dato que no sea null
            $baliza = (new Baliza)->updateOrCreate([
               'nombre' => $nombre,
               'temperatura' => $ultimoDato[1],
               'humedad' => $ultimoDato[2],
                'vel_aire' => $ultimoDato[5],
                'minutos' => $minutos
            ]);
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
