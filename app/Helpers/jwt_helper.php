<?php

use App\Models\Model_Otentikasi;
use Firebase\JWT\JWT;

function getJWT($otentikasiHeader){
    if(is_null($otentikasiHeader)){
        throw new Exception("Signature verification failed");
    }
    return explode(" ",$otentikasiHeader)[1];
}

function validateJWT($encodedToken){
    $key = getenv('JWT_SECRET_KEY');
    $decodedToken = JWT::decode($encodedToken, $key, ['HS256']);
    $modelOtentikasi = new Model_Otentikasi();
    $modelOtentikasi->getUser_name($decodedToken->user_name);
}

function createJWT($id, $user_name){
    $waktuRequest = time();
    $waktuToken = getenv('JWT_TIME_TO_LIVE');
    $waktuExpired = $waktuRequest + $waktuToken;
    $payload = [
        'id' => $id,        
        'user_name' => $user_name,        
        'iat' => $waktuRequest,
        'exp' => $waktuExpired,
    ];
    $jwt = JWT::encode($payload,getenv('JWT_SECRET_KEY'));
    return $jwt;
}