<?php

function uploadBase64Image($base64Image) {
    $target_dir = "public/";

    // Extrae el tipo de imagen y los datos de la cadena base64
    list($type, $data) = explode(';', $base64Image);
    list(, $data) = explode(',', $data);
    $type = str_replace('data:image/', '', $type);

    // Genera un nombre de archivo único
    $target_file = $target_dir . uniqid() . '.' . $type;

    // Decodifica la imagen y la guarda en el directorio
    if (file_put_contents($target_file, base64_decode($data))) {
        return basename($target_file);
    } else {
        return false;
    }
}