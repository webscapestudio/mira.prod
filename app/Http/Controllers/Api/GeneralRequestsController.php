<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\GeneralRequestEmail;
use App\Models\GeneralRequest;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Validator;

class GeneralRequestsController extends Controller
{
 
    //-----------------------------------------------------------------------------------------------------------------------
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->json()->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $gen_request = [
            'name' =>  $input['name'],
            'phone' => $input['phone']
        ];
        
        Mail::send('mails.general_request', $gen_request, function($message)use($gen_request) {
            $message->to('nikita.andenko@yandex.ru')
                    ->subject('General Request Email');          
        });

        return response()->json([
            "success" => true,
            "message" => "Request sent"
        ]);
    }

//-----------------------------------------------------------------------------------------------------------------------
}