<?php
namespace App\Http\Controllers;

use App\Models\Baliza;
use ArrayObject;
use Illuminate\Http\Request;
use Psy\Exception\ErrorException;

class BalizaController extends Controller
{
    public static function cargarDatosExtra(): ArrayObject
    {
        $url = "https://euskalmet.beta.euskadi.eus/vamet/stations/stationList/stationList.json";
        $jsonNombres = file_get_contents($url);
        $jsonNombres = utf8_encode($jsonNombres);
        $jsonNombres = json_decode($jsonNombres);
        $arDatosExtra = new ArrayObject();
        $i =0;
        foreach($jsonNombres as $datosBaliza){
            if($datosBaliza->stationType == "METEOROLOGICAL")
                $arDatosExtra->append(array("id"=>$datosBaliza->id,"nombre"=>$datosBaliza->name,"provincia"=>$datosBaliza->province,"y"=>$datosBaliza->y,"z"=>$datosBaliza->x,"tipo"=>$datosBaliza->stationType));
        }
        return $arDatosExtra;
    }
    public static function obtenerDatos()
    {
        $balizas = self::cargarDatosExtra();
        $nombres = [];
        $temperatura = null;
        $arrayDatosBalizas = [];
        //Recogemos el json de la api de arroyo
        $fechaActual = date("Y/m/d");
        for($i=0;$i<count($balizas);$i++){
            $datosFinal = [];
            $temperatura = null;
            $precipitacion = null;
            $humedad = null;
            $velocidad = null;
            $idBaliza = $balizas[$i]["id"];
            $url = "https://euskalmet.beta.euskadi.eus/vamet/stations/readings/$idBaliza/$fechaActual/readingsData.json";

            try{
                $jsonDatosBaliza = file_get_contents($url);
            }catch(\ErrorException $e){
                continue;
            }

            $jsonDatosBaliza = utf8_encode($jsonDatosBaliza);
            $jsonDatosBaliza = json_decode($jsonDatosBaliza);

            foreach ($jsonDatosBaliza as $datos){
                if($datos->name == 'temperature'){
                    foreach($datos->data as $row) {
                        $ordenar = [];
                        foreach ((array)$row as $key => $item) {
                            array_push($ordenar, $key);
                        }
                        sort($ordenar);
                        $row = json_encode($row);
                        $row = json_decode($row, true);
                        $temperatura =  $row[$ordenar[count($ordenar)-1]];

                    }
                }
                elseif($datos->name == 'precipitation') {
                    foreach($datos->data as $row) {
                        $ordenar = [];
                        foreach ((array)$row as $key => $item) {
                            array_push($ordenar, $key);
                        }
                        sort($ordenar);
                        $row = json_encode($row);
                        $row = json_decode($row, true);
                        $precipitacion =  $row[$ordenar[count($ordenar)-1]];

                    }
                }elseif($datos->name == 'humidity') {
                    foreach($datos->data as $row) {
                        $ordenar = [];
                        foreach ((array)$row as $key => $item) {
                            array_push($ordenar, $key);
                        }
                        sort($ordenar);
                        $row = json_encode($row);
                        $row = json_decode($row, true);
                        $humedad =  $row[$ordenar[count($ordenar)-1]];

                    }
                }elseif($datos->name == 'mean_speed') {
                    foreach($datos->data as $row) {
                        $ordenar = [];
                        foreach ((array)$row as $key => $item) {
                            array_push($ordenar, $key);
                        }
                        sort($ordenar);
                        $row = json_encode($row);
                        $row = json_decode($row, true);
                        $velocidad =  $row[$ordenar[count($ordenar)-1]];
                    }
                }
            }
            $datosFinal = [$idBaliza,$balizas[$i]["nombre"],$balizas[$i]["provincia"],$temperatura,$precipitacion,$humedad,$velocidad,$balizas[$i]["y"],$balizas[$i]["z"],date("Y-m-d H:m:s" )];
            array_push($arrayDatosBalizas,$datosFinal);
        }
        self::procesarDatos($arrayDatosBalizas);
    }

    public static function procesarDatos($datosFinal){
        $datosOrdenados = [];
        foreach($datosFinal as $dato){
                $datoOrdenado =
                    [
                    "id" => $dato[0],"nombre" => $dato[1] ,"provincia" => $dato[2], "temperatura" => $dato[3],
                    'precipitacion' => $dato[4], 'humedad' => $dato[5], 'velocidad' => $dato[6],
                    'y' => $dato[7], 'z' => $dato[8]
                ];
                array_push($datosOrdenados,$datoOrdenado);
        }
        (new \App\Models\Baliza)->upsert($datosOrdenados,'id');
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
