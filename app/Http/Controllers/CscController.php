<?php

namespace App\Http\Controllers;

use App\Services\LoginService;
use Illuminate\Http\Request;

class CscController extends Controller
{
    public function Consult(Request $request) : array
    {
        try{

            $login = (new LoginService())->olaConsignado($request);

            // echo"porra";
            // exit;
            return [
                'status'    => true,
                'message'   => "RETORNO",
            ];
        }catch(\Exception $e){
            return [
                'status'    => false,
                'message'   => $e->getMessage(),
            ];
            
        }

    }
}
