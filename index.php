<?php
date_default_timezone_set('America/Asuncion');
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 600);
error_reporting(0);

function load($path){foreach (glob($path) as $filename){require($filename);}}

require 'vendor/flight/Flight.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/SMTP.php';
load('src/db/*.php');
load('src/utils/*.php');
load('src/services/*.php');

cors();

Flight::set('flight.log_errors', true);

Flight::before('start', function(&$params, &$output){
    $request = Flight::request();
    if(!startsWith($request->url, Flight::get('public'))) JWT::Validar();
});

Flight::map('notFound', function(){
    die(Flight::json(ArrestDB::$HTTP[404], 404));
});

Flight::map('error', function(Throwable $ex){
    $response = ArrestDB::$HTTP[500];
    $response['message'] = $ex->getMessage() ?: 'Ha ocurrido un error inesperado';
    die(Flight::json($response, 500));
});

Flight::start();