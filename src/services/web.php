<?php


Flight::route("GET /web", function(){
    
    $webConf = DB::executeQuery("SELECT * FROM arqui_conf");
    $response = ArrestDB::$HTTP[200];
    $response['result'] = $webConf;
    return Flight::json($response, 200);

});

Flight::route("POST /web", function(){
    
    $data = Flight::request()->data;
    $campos = ['app', 'slogan', 'services_description', 'projects_description', 'facebook', 'instagram', 'telefono', 'telefono2', 'email', 'email2', 'ubicacion_url', 'direccion', 'sobre_nosotros'];

    foreach($campos as $campo){
        if(empty($data[$campo])){
            $response = ArrestDB::$HTTP[400];
            $response['message'] = "Campo $campo requerido";
            return Flight::json($response, 400);
        }
    }

    foreach($campos as $campo){
        DB::executeQuery("DELETE FROM arqui_conf WHERE clave = ?", [$campo]);
        DB::executeQuery("INSERT INTO arqui_conf (clave, valor) VALUES (?,?)", [$campo, $data[$campo]]);
    }

    $response = ArrestDB::$HTTP[200];
    return Flight::json($response, 200);

});