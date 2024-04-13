<?php

Flight::route("GET /servicios", function(){

    $servicios = DB::executeQuery("SELECT * FROM arqui_servicio ORDER BY fecha_creacion DESC");

    $response = ArrestDB::$HTTP[200];
    $response['result'] = $servicios;
    return Flight::json($response, 200);

});

Flight::route("POST /servicio", function(){

    $data = Flight::request()->data;
    $nombre = $data['nombre'];
    $descripcion = $data['descripcion'];
    $icono = $data['icono'];

    $servicio = DB::executeQuery("SELECT * FROM arqui_servicio WHERE nombre = ?", [$nombre]);
    if(count($servicio) > 0){
        $response = ArrestDB::$HTTP[400];
        $response['message'] = "Servicio $nombre ya existe";
        return Flight::json($response, 400);
    }

    DB::executeQuery("INSERT INTO arqui_servicio (nombre, descripcion, icono) VALUES(?,?,?)", [$nombre, $descripcion, $icono]);

    $response = ArrestDB::$HTTP[200];
    return Flight::json($response, 200);

});

Flight::route("PUT /servicio/@id:[0-9]+", function($id){

    $data = Flight::request()->data;
    $nombre = $data['nombre'];
    $descripcion = $data['descripcion'];
    $icono = $data['icono'];

    $servicio = DB::executeQuery("SELECT * FROM arqui_servicio WHERE nombre = ?", [$nombre]);
    if(count($servicio) > 0){
        $servicio = array_shift($servicio);
        if($servicio->id !== $id){
            $response = ArrestDB::$HTTP[400];
            $response['message'] = "El servicio $nombre ya existe";
            return Flight::json($response, 400);
        }
    }

    DB::executeQuery("UPDATE arqui_servicio SET nombre = ?, descripcion = ?, icono = ? WHERE id = ?", [$nombre, $descripcion, $icono, $id]);

    $response = ArrestDB::$HTTP[200];
    return Flight::json($response, 200);

});

Flight::route("DELETE /servicio/@id:[0-9]+", function($id){

    DB::executeQuery("DELETE FROM arqui_servicio WHERE id = ?", [$id]);

    $response = ArrestDB::$HTTP[200];
    return Flight::json($response, 200);

});