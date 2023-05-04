<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ResumeRequestEmail;
use App\Models\ResumeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Validator;
use Illuminate\Support\Str;
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

    if($request->get('attachment') and $request->get('comment')):
        $image_64 =$input['attachment']; //your base64 encoded data
        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
        $replace = substr($image_64, 0, strpos($image_64, ',')+1);     
      // find substring fro replace here eg: data:image/png;base64,
        $image = str_replace($replace, '', $image_64); 
        $image = str_replace(' ', '+', $image); 
        $imageName = Str::random(10).'.'.$extension;
        Storage::disk('public')->put($imageName, base64_decode($image));

        $file= public_path('storage/'.$imageName);
        $res_request = [
            'name' =>  $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'comment' => $input['comment'],
            'department'=> $input['department']
        ];

        Mail::send('mails.resume_request', $res_request, function($message)use ($file) {
        $message->to(env('MAIL_TO_ADDRESS'))->subject('Resume Request Email'); 
        $message->attach($file);
        });
        elseif($request->get('comment')):
            $res_request = [
                'name' =>  $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'comment' => $input['comment'],
                'department'=> $input['department']
                ];
            Mail::send('mails.resume_request', $res_request, function($message) {
            $message->to(env('MAIL_TO_ADDRESS'))->subject('Resume Request Email'); 
            });
    elseif($request->get('attachment')):
        $image_64 =$input['attachment']; //your base64 encoded data
        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
        $replace = substr($image_64, 0, strpos($image_64, ',')+1);     
      // find substring fro replace here eg: data:image/png;base64,
        $image = str_replace($replace, '', $image_64); 
        $image = str_replace(' ', '+', $image); 
        $imageName = Str::random(10).'.'.$extension;
        Storage::disk('public')->put($imageName, base64_decode($image));

        $file= public_path('storage/'.$imageName);
        $res_request = [
            'name' =>  $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'department'=> $input['department']
        ];

        Mail::send('mails.resume_request', $res_request, function($message)use ($file) {
        $message->to(env('MAIL_TO_ADDRESS'))->subject('Resume Request Email'); 
        $message->attach($file);
        });
    else:
        $res_request = [
            'name' =>  $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'department'=> $input['department']
            ];
        Mail::send('mails.resume_request', $res_request, function($message) {
        $message->to(env('MAIL_TO_ADDRESS'))->subject('Resume Request Email'); 
        });
    endif;

        return response()->json([
            "success" => true,
            "message" => "Request sent"
        ]);
    }
}
