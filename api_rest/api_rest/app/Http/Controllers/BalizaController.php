<?php
namespace App\Http\Controllers;

use App\Models\Baliza;
use Illuminate\Http\Request;

class BalizaController extends Controller
{
    public static function obtenerDatos()
    {
        $fechaActual = date("d/m/Y");
        //Nombres de balizas
        $nombresBalizas=
            [
                "Abetxuko","Abetxuko-CHE","Abusu","Agauntza","Aitzu","Aixola","Aizarnazabal",
                "Albaina","Alegia","Alegría","Almike (Bermeo)","Altube","Altzola","Ameraun",
                "Amorebieta","Amundarain","Andoain","Antoñana","Añarbe","Aranguren","Araxes",
                "Arboleda","Areta","Arkaute I","Arkauti","Arrasate","Arteaga","Baiko","Balmaseda",
                "Behobia","Belauntza","Beluntza","Berastegi","Berna","Berriatua","Bidania","Cerroja",
                "Derio","Deusto","Egino","Eibar","Eitzaga","Elorrio","Ereñozu","Eskas","Espejo",
                "Estanda","Etura","Galdakao","Galindo","Gardea","Gazteiz","Gatika","Gorbea","Herrera",
                "Higer","Ibai Eder","Igorre","Ilarduia","Iruzubieta","Iturrieta","Lurreta","Jaizkibel",
                "Jaizubia","Kanpezu","Kapildui","La Garbea","La Merced","Larrainazubi","Lasarte","Mallabia",
                "Mañaria","Mareógrafo Bermeo","Markina","Martutene","Matxinbenta","Matxitxako","Miramon",
                "Moreda","Mungia","Mungia-Lauaxeta","Muxika","Navarrete","Oiartzun","Oiz","Olabarria","Oleta",
                "Oñati","Ordizia","Ordunte","Orduña","Orozko","Otxandio","Ozaeta","Páganos","Pagoeta","Puerto de Bilbao",
                "Puerto de Pasaia","Punta Galea","Roitegi","Salvatierra","San Prudentzio","Sangroniz","Santa Clara",
                "Saratxo","Sarria","Sodupe-Cadagua","Sodupe-Herrerias","Subijana","Tobillas","Trebiño","Txomin Enea",
                "Undurraga","Untzueta","Urkiola","Urkizu","Urkulu","Venta Alta","Zaldiaran","Zalla","Zambrana",
                "Zaratamo","Zarautz","Zeanuri","Zegama","Zizurkil","Zurbano-Alegría-CHE"
            ];
        for ($i =0; $i<count($nombresBalizas);$i++){
            $nombreURL = urlencode(utf8_decode($nombresBalizas[$i]));
            $url = "https://www.euskalmet.euskadi.eus/s07-5853x/es/meteorologia/datos/graficasMeteogene.apl?e=5&nombre=$nombreURL&fechasel=$fechaActual&R01HNoPortal=true";

            require('domparser/simple_html_dom.php');
            $html = file_get_html($url);
            $table = $html->find('table');

            $rowHeader = array();
            for($table->find('tr') as $row){
                $meteo = array();
                for($row->find('th') as $cell){
                    $meteo[] = $cell->plaintext;
                }
                $rowHeader[] = $meteo;
            }
            for($table->find('tr') as $row){
                $meteo = array();
                for($row->find('td') as $cell){
                    $meteo[] = $cell->plaintext;
                }
                $rowData[] = $meteo;
            }
            print_r($rowHeader);
            print_r($rowData);
        }
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
