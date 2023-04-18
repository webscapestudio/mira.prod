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
        return response()->json($contacts);
    }
}
