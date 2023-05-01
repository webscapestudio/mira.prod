<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\GeneralRequestEmail;
use App\Models\GeneralRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
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
            'name'       => 'required',
            'phone'      => 'required',
            'email'      => 'required|email',
            'name_form'  => 'required',
            'id_form'    => 'required',
            'comment'    => 'required',
            'domain'     => 'required',
            'utm_source' => 'nullable',
            'utm_medium' => 'nullable',
            'utm_term'   => 'nullable',
            'utm_content'=> 'nullable',
            'utm_campaign' => 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $gen_request = [
            'name' =>  $input['name'],
            'phone' => $input['phone'],
        ];

        $amoCRM_request = $gen_request + [
            'email' => $input['email'],
            'name_form' => $input['name_form'],
            'id_form' => $input['id_form'],
            'comment' => $input['comment'],
            'geoip' => geoip($request->ip()),
            'domain' => $input['domain'],
            'utm_source' => $input['utm_source'] ?? env('UTM_SOURCE'),
            'utm_medium' => $input['utm_medium'] ?? env('UTM_MEDIUM'),
            'utm_term' => $input['utm_term'] ?? env('UTM_TERM'),
            'utm_content' => $input['utm_content'] ?? env('UTM_CONTENT'),
            'utm_campaign' => $input['utm_campaign'] ?? env('UTM_CAMPAIGN'),
        ];

        try {
            $response = Http::post(env('AMO_CRM_URL'), $amoCRM_request);

            if ($response->failed()) {
                return response()->json([
                    "success" => false,
                    "message" => "Request not sent"
                ]);
            }

            Mail::send('mails.general_request', $gen_request, function($message)use($gen_request) {
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

//-----------------------------------------------------------------------------------------------------------------------
}
