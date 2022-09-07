<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class DapiController extends Controller
{
    public function index()
    {
        $data = array();

        if(Session::has('dapiAccess')){
            $userSecret = session('dapiAccess')['userSecret'];
            $accessToken = session('dapiAccess')['accessToken'];
            $dapiClient = new \Dapi\DapiClient('0f78b93a6c5937ee3af83d2ee30b3d5c302e46b6ab1460e0a01f6675777934a3');

            $identity = $dapiClient->data->getIdentity($accessToken, $userSecret);

            $data['identity'] = (json_encode($identity, JSON_PRETTY_PRINT) . "\n");

            $accounts = $dapiClient->data->getAccounts($accessToken, $userSecret);
            $data['account']['1'] = PHP_EOL . 'Accounts!' . PHP_EOL . PHP_EOL;
            $data['account']['2'] = (json_encode($accounts, JSON_PRETTY_PRINT));

            $accountID = $accounts['accounts'][0]['id'];
            $data['accountID'] = PHP_EOL . "accountID: " . $accountID; 

            $balance = $dapiClient->data->getBalance($accessToken, $userSecret, $accountID); 
            $data['balance']['1'] =  PHP_EOL . 'Balance!' . PHP_EOL . PHP_EOL;
            $data['balance']['2'] = (json_encode($balance, JSON_PRETTY_PRINT));

            $transactions = $dapiClient->data->getTransactions($accessToken, $userSecret, $accountID, "2021-02-14", "2021-05-11"); 
            $data['transaction']['1'] = PHP_EOL . 'Transactions!' . PHP_EOL . PHP_EOL;
            $data['transaction']['2'] = (json_encode($transactions, JSON_PRETTY_PRINT));

            $metadata = $dapiClient->metadata->getAccountsMetadata($accessToken, $userSecret); 
            $data['acc_meta']['1'] = PHP_EOL . 'Accounts Metadata!' . PHP_EOL . PHP_EOL;
            $data['acc_meta']['2'] = (json_encode($transactions, JSON_PRETTY_PRINT));
        }

        return view('index')->compact('data');
    }

    public function dislink_user()
    {
        # code...
    }

    public function get_access_token(Request $request)
    {
        // header("Access-Control-Allow-Origin: *");
        // header("Content-Type: application/json; charset=UTF-8");
        // header("Access-Control-Allow-Methods: POST");
        // header("Access-Control-Max-Age: 3600");
        // header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        // curl --request POST \
        // --url https://api.dapi.com/v2/auth/ExchangeToken \
        // --header 'Content-Type: application/json' \
        // --data '{
        //     "appSecret": "app_secret_value",
        //     "accessCode": "access_code_value",
        // "connectionID": "connectionID_value"
        // }' 

        //header("Content-Type: application/json");
        if(Session::has('dapiAccess')){
            $request->session()->forget('dapiAccess');
            $request->session()->flush();
        }

        $tokenID =  $request->tokenID;
        $userID =  $request->userID;
        $accessCode =  $request->accessCode;
        $connectionID =  $request->connectionID;
        $userSecret = $request->userSecret;

        $apiURL = 'https://api.dapi.com/v2/auth/ExchangeToken';

      	// POST Data
        $postInput = [
            'appSecret' => '0f78b93a6c5937ee3af83d2ee30b3d5c302e46b6ab1460e0a01f6675777934a3',
            'accessCode' => $accessCode,
            'connectionID' => $connectionID,
        ];
  
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $apiURL, ['json' => $postInput, [
            'allow_redirects' => true,
            'timeout' => 2000,
            'http_errors' => true
        ] ]);
     
        $statusCode = $response->getStatusCode();
        $responseBody = json_decode($response->getBody(), true);
        
        if($responseBody['success']){
            Session::put('dapiAccess', [
                'accessToken'=>$responseBody['accessToken'], 
                'tokenID'=>$responseBody['tokenID'], 
                'userID'=>$responseBody['userID'],
                'userSecret'=>$userSecret
            ]);
            return response()->json(['status'=>true, 'message'=>''], 200);
        }else{
            return response()->json(['status'=>false, 'message'=>'Unable to connect and set access token. Refresh your page.'], 200);
        }   
    }

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
