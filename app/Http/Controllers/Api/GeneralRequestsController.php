<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Validator;

class GeneralRequestsController extends Controller
{

    //-----------------------------------------------------------------------------------------------------------------------
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->json()->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'name_form' => 'required',
            'id_form' => 'required',
            'comment' => 'required',
            'domain' => 'required',
            'utm_source' => 'nullable',
            'utm_medium' => 'nullable',
            'utm_term' => 'nullable',
            'utm_content' => 'nullable',
            'utm_campaign' => 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $gen_request = [
            'name' => $input['name'],
            'phone' => $input['phone'],
        ];

        $amoCRM_request = [
            'add' => [
                [
                    'name' => $input['name'],
                    'phone' => $input['phone'],
                    'email' => $input['email'],
                    'name_form' => $input['name_form'],
                    'id_form' => $input['id_form'],
                    'comment' => $input['comment'],
                    'domain' => $input['domain'],
                ]
            ]];

        try {
            if (!file_exists("tokens.txt")) {
                $this->baseAuth();
            }

            $dataToken = file_get_contents("tokens.txt");
            $dataToken = json_decode($dataToken, true);

            if ($dataToken["endTokenTime"] - 60 < time()) {
                $access_token = $this->refreshTokenAuth($dataToken["refresh_token"]);
            } else {
                $access_token = $dataToken["access_token"];
            }
            
            $client = new Client([
                'verify' => false,
            ]);

            $headers = [
                'Authorization' => 'Bearer ' . $access_token,
                'Accept' => 'application/json',
            ];
            
            $response = $client->request('POST', config("services.ammo_crm.url") . 'api/v2/leads', [
                'headers' => $headers,
                RequestOptions::JSON => $amoCRM_request,
            ]);

            if ($response->getStatusCode() >= 400) {
                return response()->json([
                    "success" => false,
                    "message" => "Request not sent"
                ]);
            }

            Mail::send('mails.general_request', $gen_request, function ($message) use ($gen_request) {
                $message->to(env('MAIL_TO_ADDRESS'))                                            //почта
                ->subject('General Request Email');
            });
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => "Request not sent"
            ]);
        }


        return response()->json([
            "success" => true,
            "message" => "Request sent"
        ]);
    }

    private function baseAuth(): void
    {
        $response = Http::withOptions([
            'verify' => false,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ])
            ->post(config("services.ammo_crm.url") . "oauth2/access_token", [
                'client_id' => config("services.ammo_crm.client_id"),
                'client_secret' => config("services.ammo_crm.client_secret"),
                'grant_type' => 'authorization_code',
                'code' => config("services.ammo_crm.code"),
                'redirect_uri' => config("services.ammo_crm.redirect"),
            ]);

        if ($response->failed()) {
            response()->json([
                "success" => false,
                "message" => "Request not sent"
            ]);
            return;
        }

        $response = json_decode($response->body(), true);

        $arrParamsAmo = [
            "access_token" => $response['access_token'],
            "refresh_token" => $response['refresh_token'],
            "token_type" => $response['token_type'],
            "expires_in" => $response['expires_in'],
            "endTokenTime" => $response['expires_in'] + time(),
        ];

        $arrParamsAmo = json_encode($arrParamsAmo);

        $f = fopen("tokens.txt", 'w');
        fwrite($f, $arrParamsAmo);
        fclose($f);
    }

    private function refreshTokenAuth(string $refresh_token): string
    {
        $response = Http::withOptions([
            'verify' => false,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ])
            ->post(config("services.ammo_crm.url") . "oauth2/access_token", [
                'client_id' => config("services.ammo_crm.client_id"),
                'client_secret' => config("services.ammo_crm.client_secret"),
                'grant_type' => 'refresh_token',
                'refresh_token' => $refresh_token,
                'redirect_uri' => config("services.ammo_crm.redirect"),
            ]);

        if ($response->failed()) {
            return response()->json([
                "success" => false,
                "message" => "Request not sent"
            ]);
        }

        $response = json_decode($response->body(), true);

        $arrParamsAmo = [
            "access_token" => $response['access_token'],
            "refresh_token" => $response['refresh_token'],
            "token_type" => $response['token_type'],
            "expires_in" => $response['expires_in'],
            "endTokenTime" => $response['expires_in'] + time(),
        ];

        $arrParamsAmo = json_encode($arrParamsAmo);

        $f = fopen("tokens.txt", 'w');
        fwrite($f, $arrParamsAmo);
        fclose($f);

        return $response['access_token'];
    }

//-----------------------------------------------------------------------------------------------------------------------
}
