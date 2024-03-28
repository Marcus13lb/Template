<?php

Flight::route("GET /proyectos", function(){

    $proyectos = DB::executeQuery("SELECT * FROM arqui_proyecto ORDER BY fecha_creacion DESC");

    foreach($proyectos as &$proyecto){
        $proyecto->fotos = explode(",", $proyecto->fotos);
    }

    $response = ArrestDB::$HTTP[200];
    $response['result'] = $proyectos;
    return Flight::json($response, 200);

});

Flight::route("POST /proyecto", function(){

    $data = Flight::request()->data;
    $nombre = $data['nombre'];
    $descripcion = $data['descripcion'];
    $fotos = $data['fotos'];
    $fotosSubidas = [];

    $proyecto = DB::executeQuery("SELECT * FROM arqui_proyecto WHERE nombre = ?", [$nombre]);
    if(count($proyecto) > 0){
        $response = ArrestDB::$HTTP[400];
        $response['message'] = "Proyecto $nombre ya existe";
        return Flight::json($response, 400);
    }

    // Guardamos fotos
    foreach($fotos as $foto){
        $fileName = uploadBase64Image($foto);
        if($fileName !== false){
            $fotosSubidas[] = $fileName;
        }
    }

    $fotosSubidas = count($fotosSubidas) > 0 ? implode(",", $fotosSubidas) : null;

    DB::executeQuery("INSERT INTO arqui_proyecto (nombre, descripcion, fotos) VALUES(?,?,?)", [$nombre, $descripcion, $fotosSubidas]);

    $response = ArrestDB::$HTTP[200];
    return Flight::json($response, 200);

});

Flight::route("DELETE /proyecto/@id:[0-9]+", function($id){

    DB::executeQuery("DELETE FROM arqui_proyecto WHERE id = ?", [$id]);

    $response = ArrestDB::$HTTP[200];
    return Flight::json($response, 200);

});