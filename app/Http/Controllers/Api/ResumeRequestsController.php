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
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'comment' => 'nullable',
            'attachment' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        if (isset($input['attachment'])) :
            $input['attachment'] = Storage::disk('public')->put('/mail',  $input['attachment']);
        endif;
        $res_request = ResumeRequest::create([
            'name' =>  $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'comment' => $input['comment'],
            'attachment' => $input['attachment'],
        ]);
        Mail::to('nikita.andenko@yandex.ru')->send(new ResumeRequestEmail($res_request));

        return response()->json([
            "success" => true,
            "message" => "Request sent"
        ]);
    }
}
