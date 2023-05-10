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
use Illuminate\Support\Facades\Route;
class GeneralRequestsController extends Controller
{


    public function store(Request $request)
    {
        $input = $request->all();
        if($request->get('utm_source') and $request->get('utm_medium') and $request->get('utm_campaign')):
            $array = [
                'name'    =>  $input['name'],
                'phone'    => $input['phone'],
                'geoip'    =>file_get_contents('http://ip-api.com/line/'.geoip($request->ip())->ip.'?fields=country'),
                'comment'    => $input['url'], 
                'domain'=> $input['url'],
                'utm_source'=> $input['utm_source'], 
                'utm_medium'=> $input['utm_medium'], 
                'utm_campaign'=> $input['utm_campaign']
              ];
        elseif ($request->get('utm_source') and $request->get('utm_medium')):
            $array = [
                'name'    =>  $input['name'],
                'phone'    => $input['phone'],
                'geoip'    =>file_get_contents('http://ip-api.com/line/'.geoip($request->ip())->ip.'?fields=country'),
                'comment'    => $input['url'], 
                'domain'=> $input['url'],
                'utm_source'=> $input['utm_source'], 
                'utm_medium'=> $input['utm_medium']
              ];
        elseif ($request->get('utm_source') and $request->get('utm_campaign')):
            $array = [
                'name'    =>  $input['name'],
                'phone'    => $input['phone'],
                'geoip'    =>file_get_contents('http://ip-api.com/line/'.geoip($request->ip())->ip.'?fields=country'),
                'comment'    => $input['url'], 
                'domain'=> $input['url'],
                'utm_source'=> $input['utm_source'], 
                'utm_campaign'=> $input['utm_campaign']
                ];
        elseif ($request->get('utm_medium') and $request->get('utm_campaign')):
            $array = [
                'name'    =>  $input['name'],
                'phone'    => $input['phone'],
                'geoip'    =>file_get_contents('http://ip-api.com/line/'.geoip($request->ip())->ip.'?fields=country'),
                'comment'    => $input['url'], 
                'domain'=> $input['url'],
                'utm_medium'=> $input['utm_medium'], 
                'utm_campaign'=> $input['utm_campaign']
                ];
        elseif ($request->get('utm_source')):
            $array = [
                'name'    =>  $input['name'],
                'phone'    => $input['phone'],
                'geoip'    =>file_get_contents('http://ip-api.com/line/'.geoip($request->ip())->ip.'?fields=country'),
                'comment'    => $input['url'], 
                'domain'=> $input['url'],
                'utm_source'=> $input['utm_source']
                ];
        elseif ($request->get('utm_medium')):
            $array = [
                'name'    =>  $input['name'],
                'phone'    => $input['phone'],
                'geoip'    =>file_get_contents('http://ip-api.com/line/'.geoip($request->ip())->ip.'?fields=country'),
                'comment'    => $input['url'], 
                'domain'=> $input['url'],
                'utm_medium'=> $input['utm_medium']
                ];
        elseif ($request->get('utm_campaign')):
            $array = [
                'name'    =>  $input['name'],
                'phone'    => $input['phone'],
                'geoip'    =>file_get_contents('http://ip-api.com/line/'.geoip($request->ip())->ip.'?fields=country'),
                'comment'    => $input['url'], 
                'domain'=> $input['url'],
                'utm_campaign'=> $input['utm_campaign']
                ];
        else:
            $array = [
                'name'    =>  $input['name'],
                'phone'    => $input['phone'],
                'geoip'    =>file_get_contents('http://ip-api.com/line/'.geoip($request->ip())->ip.'?fields=country'),
                'comment'    => $input['url'],
                'domain'=> $input['url'],
                ];
        endif;

              $ch = curl_init('https://mtlead.ru/api.php');
              curl_setopt($ch, CURLOPT_POST, 1);
              curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($array, '', '&'));
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
              curl_setopt($ch, CURLOPT_HEADER, false);
              $html = curl_exec($ch);
              curl_close($ch);

    }
}