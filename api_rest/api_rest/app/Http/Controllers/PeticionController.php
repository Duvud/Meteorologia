<?php
namespace App\Http\Controllers;

use App\Models\Peticion;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeticionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Index(): \Illuminate\Http\JsonResponse
    {
        //Comprobamos el usuario logeado
        $user = Auth::user();
        if(!is_null($user)){
            $peticiones = Peticion::where("user", $user->email)->get();
            if(count($peticiones) > 0) {
                return response()->json(["status" => "success", "count" => count($peticiones), "data" => $peticiones], 200);
            }else {
                return response()->json(["status" => "failed", "count" => count($peticiones), "message" => "No se ha encontrado ninguna peticion a nombre de este usuario"], 200);
            }
        }
    }

    /**
     * Almacena una nueva petición en la base de datos
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function Store(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        if(!is_null($user)) {
            //Creamos la peticion
            $validator      =   Validator::make($request->all(), [
                "user" => "required",
                "baliza" => "required",
            ]);
            if($validator->fails()) {
                return response()->json(["status" => "failed", "validation_errors" => $validator->errors()]);
            }
            $datosPeticion = $request->all();
            $datosPeticion['user'] = $user->email;
            $arDatosPeticion = [$datosPeticion['user'],$datosPeticion['baliza']];
            $peticion = Peticion::updateOrCreate(
                [
                    'baliza' => $datosPeticion['baliza'], 'user' => $datosPeticion['user']
                ],
                $arDatosPeticion
            );
            if(!is_null($peticion)) {
                return response()->json(["status" => "success", "message" => "Petición creada", "data" => $peticion]);
            }else {
                return response()->json(["status" => "failed", "message" => "Error al crear petición"]);
            }
        }else{
            return response()->json(["status" => "failed", "message" => "Usuario no autorizado, para acceder, paga"], 403);
        }
    }

    /**
     * Enseña la petición seleccionada
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function Show(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        if(!is_null($user)) {
            $peticion = Peticion::where("user", $user->id)->first();
            if(!is_null($peticion)) {
                return response()->json(["status" => "success", "data" => $peticion], 200);
            }
            else {
                return response()->json(["status" => "failed", "message" => "Error al buscar la petición"], 200);
            }
        }
        else {
            return response()->json(["status" => "failed", "message" => "Usuario no autorizado, para acceder, paga"], 403);
        }
    }

    public function Destroy(Request $request)
    {
        $user = Auth::user();
        if(!is_null($user)) {
            $peticion =  Peticion::where("baliza", $request["baliza"])->where("user", $user->email)->delete();
            return response()->json(["status" => "success", "message" => "Success! task deleted", "data" => $request["baliza"]], 200);
        }
        else {
            return response()->json(["status" => "failed", "message" => "Un-authorized user"], 403);
        }
    }
}
