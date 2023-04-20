<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
class UploadFileController extends Controller
{
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'attachment'=> 'required|file'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $uploadFolder = 'files';
        $image = $request->file('attachment');
        $image_uploaded_path = $image->store($uploadFolder, 'public');
        $uploadedImageResponse = array(
           "file_name" => basename($image_uploaded_path),
           "file_url" => Storage::disk('public')->url($image_uploaded_path),
           "mime" => $image->getClientMimeType()
        );

        return response()->json([
            "success" => true,
            "message" => "File Uploaded Successfully",
            "attachment"=>$uploadedImageResponse
        ]);
    }
}
