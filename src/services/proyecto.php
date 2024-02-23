<?php

Flight::route("GET /proyectos", function(){

    $proyectos = DB::executeQuery("SELECT * FROM arqui_proyecto ORDER BY fecha_creacion DESC");

    $response = ArrestDB::$HTTP[200];
    $response['result'] = $proyectos;
    return Flight::json($response, 200);

});

Flight::route("POST /proyecto", function(){

    $data = Flight::request()->data;
    $nombre = $data['nombre'];
    $descripcion = $data['descripcion'];
    $fotos = $data['fotos'];

    $proyecto = DB::executeQuery("SELECT * FROM arqui_proyecto WHERE nombre = ?", [$nombre]);
    if(count($proyecto) > 0){
        $response = ArrestDB::$HTTP[400];
        $response['message'] = "proyecto $nombre ya existe";
        return Flight::json($response, 400);
    }

    DB::executeQuery("INSERT INTO arqui_proyecto (nombre, descripcion, fotos) VALUES(?,?,?)", [$nombre, $descripcion, $fotos]);

    $response = ArrestDB::$HTTP[200];
    return Flight::json($response, 200);

});

Flight::route("DELETE /proyecto/@id:[0-9]+", function($id){

    DB::executeQuery("DELETE FROM arqui_proyecto WHERE id = ?", [$id]);

    $response = ArrestDB::$HTTP[200];
    return Flight::json($response, 200);

});