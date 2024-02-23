<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['fileToUpload'])) {

    header('Content-Type: application/json');
    
    $target_dir = "public/";
    $file = $_FILES['fileToUpload'];

    // Obtén la extensión del archivo
    $fileType = strtolower(pathinfo($file["name"],PATHINFO_EXTENSION));

    // Verifica si el archivo es una imagen
    $check = getimagesize($file["tmp_name"]);
    if($check === false) {
        echo json_encode(['error' => 'El archivo no es una imagen.']);
        return;
    }

    // Verifica si la extensión del archivo es válida
    $valid_extensions = array("jpg", "jpeg", "png", "gif");
    if(!in_array($fileType, $valid_extensions)) {
        echo json_encode(['error' => 'Solo se permiten archivos JPG, JPEG, PNG y GIF.']);
        return;
    }

    // Genera un nombre de archivo único
    $target_file = $target_dir . md5(time()) . '.' . $fileType;

    // Intenta mover el archivo subido al destino
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        // Retorna un JSON con el nombre del archivo
        echo json_encode(['fileName' => basename($target_file)]);
    } else {
        echo json_encode(['error' => 'Hubo un error al subir el archivo.']);
    }
}
