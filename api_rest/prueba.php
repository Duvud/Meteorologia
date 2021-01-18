<?php

//Strings utilizados para los replace
$sReplace1 = '[
   ,';
$sReplace2 = ',,,,,,,';
$sReplace3 = ',,,,,';
$sReplace4 = ',,,,,,';
$sReplace5 = '$ar = [



                                                                                                                 [
   ]
';
$sReplace6 = ' [
   ]
   ,
';
$sReplace7 = ',
   ]
';
$sReplace8 = ' [
,';
$sReplace9 = '[,';
$sReplace10 = ',,';
$sReplace11 = ',,)';
//----------------------------------------------------
//Obtenemos el día de hoy en el formato día/mes/año
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
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    $resp = curl_exec($curl);
    curl_close($curl);
    if (preg_match('/arrayDatos=([^;]+)/',$resp,$matches)) {
        $arr =  $matches[1];
        $arr = str_replace([$sReplace1,$sReplace8,$sReplace9], '[',$arr);
        $arr = str_replace([$sReplace2,$sReplace3,$sReplace4,$sReplace5,$sReplace6], '',$arr);
        $arr = str_replace($sReplace7, ']',$arr);
        $arr = str_replace($sReplace10, ',',$arr);
        preg_replace('/]\s,/', ']', $arr);
        $arr = (str_replace(array('[',']'),array('array(',')'),$arr)).';';
        $arr = str_replace($sReplace11, ')',$arr);
        //echo $arr;
        $arr = eval("return  " . $arr .";");
        $lastData = [];

        for($z=0;$z<count($arr);$z++){
            if(count($arr[$z])== 1 && $arr[$z][0] == 0 || count($arr[$z]) < 4 ){
                    if($z !== 0) {
                        $lastData = $arr[$z - 1];
                        echo print_r($lastData);
                        echo " | " . $url;
                        $z = count($arr);
                    }else{
                        echo "no ". $url;
                    }
            }
        }
    }
}
?>

