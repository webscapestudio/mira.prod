<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ResumeRequestEmail;
use App\Models\GeneralRequest;
use App\Models\ResumeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Validator;

class ResumeRequestsController extends Controller
{
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
            'email' => 'required',
            'phone' => 'required',
            'comment' => 'nullable',
            'department'=>'required',
            'attachment'=> 'nullable'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        if($request['attachment']):
            $files = $request['attachment'];
        endif;

        $res_request = [
            'name' =>  $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'comment' => $input['comment'],
            'department'=> $input['department'],
        ];
  

      Mail::send('mails.resume_request', $res_request, function($message)use ($files) {
            $message->to(env('MAIL_TO_ADDRESS'))                                                  //почта
                    ->subject('Resume Request Email'); 
                    foreach ($files as $file){
                        $message->attach($file);
                    }
                    });
      
        return response()->json([
            "success" => true,
            "message" => "Request sent"
        ]);
    }
}
