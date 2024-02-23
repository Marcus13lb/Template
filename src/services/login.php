<?php

Flight::route("POST /login", function (){

    $data = Flight::request()->data;
    $user = $data['user'];
    $pw = $data['pw'];

    if(!is_string($pw) || !is_string($user)){
        return Flight::json(ArrestDB::$HTTP[400], 400);
    }

    $env = DB::getEnvironment();

    if($user === $env['ADM_USR'] && $pw === $env['ADM_PSW']){

        $token = JWT::Generar($user);
        
        $response = ArrestDB::$HTTP[200];
        $response['result'] = $token;
        return Flight::json($response, 200);
        
    }
    
    $response = ArrestDB::$HTTP[400];
    $response['message'] = 'Usuario y/o contraseña incorrecta';
    return Flight::json($response, 400);

});