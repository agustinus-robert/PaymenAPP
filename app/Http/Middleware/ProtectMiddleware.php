<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProtectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data= $request->all();
        $pathForPrivateKey=base_path("private.pem");
        $privateKey = file_get_contents($pathForPrivateKey);
        $pathForPublicKey=base_path("public.pem");
        $publicKey = file_get_contents($pathForPublicKey);
        $headers_to_decrypt=["Authorization","secretKey","publicKey"];
        foreach($headers_to_decrypt as $header){
            $value=$request->header($header);
            if(!empty($value)){
                $decryptedData = '';
                $is_unchanged=openssl_private_decrypt(base64_decode($value), $decryptedData, $privateKey);
                if(!$is_unchanged){
                    return response()->json(['version' => 'NA','result' => "999", 'message' => "Malicious Activity Detected", 'data' => []]);
                }
                $request->headers->set($header,$decryptedData);
            }
        }
        foreach($data as $key=>$value){
            $decryptedData = '';
            $is_unchanged=openssl_private_decrypt(base64_decode($value), $decryptedData, $privateKey);
            if(!$is_unchanged){
                return response()->json(['version' => 'NA','result' => "999", 'message' => "Malicious Activity Detected", 'data' => []]);
            }
           $request->{$key}=$decryptedData;
        }
        
        $response_data = $next($request);
        $json_data=json_encode($response_data->original);
        $encryptedData="";
        openssl_public_encrypt($json_data, $encryptedData, $publicKey);  
        $response_data->setData(['data' => base64_encode($encryptedData)]);
        return $response_data;
    }
}
