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
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'phone' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $gen_request = GeneralRequest::create($input);
        
        Mail::to('nikita.andenko@yandex.ru')->send(new GeneralRequestEmail($gen_request));

        return response()->json([
            "success" => true,
            "message" => "Request sent"
        ]);
    }

//-----------------------------------------------------------------------------------------------------------------------
}