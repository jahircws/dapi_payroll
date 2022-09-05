<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dapi;


class DapiController extends Controller
{
    public function dapi(Request $request)
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        // Initialize DapiClient with your appSecret here
        $dapiClient = new \Dapi\DapiClient('0f78b93a6c5937ee3af83d2ee30b3d5c302e46b6ab1460e0a01f6675777934a3');

        $headers = getallheaders();
        $body = json_decode(file_get_contents("php://input"), true);

        // Make dapiClient automatically handle your SDK requests
        if (!empty($body)) {
        echo json_encode($dapiClient->handleSDKRequests($body, $headers)); 
        } else {
        http_response_code(400);
        echo "Bad Request: No data sent or wrong request";
        }
    }
}
