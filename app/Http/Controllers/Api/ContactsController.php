<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContactsResource;
use App\Models\Contacts;

class ContactsController extends Controller
{
    public function index()
    {
        $contacts =ContactsResource::collection(Contacts::get());
        if(!$contacts->isEmpty()):
            return response()->json(...$contacts);
        else:
            return response()->json([
                'error'=>'not found',
            ],404);
        endif;

    }
}
