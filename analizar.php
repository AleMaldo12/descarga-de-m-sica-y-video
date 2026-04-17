<?php

header('Content-Type: application/json');

$audio = $_POST['audio'];

// 🔥 RUTA REAL DEL AUDIO
$audioPath = realpath(__DIR__ . DIRECTORY_SEPARATOR . $audio);

// 🔥 RUTA REAL DEL SCRIPT
$script = realpath(__DIR__ . DIRECTORY_SEPARATOR . "transcribir.py");

// 🔥 PYTHON (RUTA ABSOLUTA)
$python = "C:\\Python313\\python.exe";

// ❌ VALIDACIONES
if (!$audioPath || !file_exists($audioPath)) {
    echo json_encode([["texto"=>"Error: audio no encontrado","emocion"=>"neutral"]]);
    exit;
}

if (!$script) {
    echo json_encode([["texto"=>"Error: script no encontrado","emocion"=>"neutral"]]);
    exit;
}

// 🔥 COMANDO CORRECTO
$comando = "\"$python\" \"$script\" \"$audioPath\"";

// 🔥 EJECUCIÓN SEGURA
exec($comando . " 2>&1", $salida, $codigo);

$output = implode("\n", $salida);

// ❌ SI FALLA PYTHON

// 🔥 PROCESAR TEXTO
$lineas = explode(".", $output);

$resultado = [];

foreach ($lineas as $l) {
    $resultado[] = [
        "texto" => trim($l),
        "emocion" => "neutral"
    ];
}

echo json_encode($resultado);

header('Content-Type: application/json');

// limpiar texto (opcional pero recomendado)
$output = mb_convert_encoding($output, 'UTF-8', 'auto');

$lineas = explode(".", $output);

$resultado = [];

foreach ($lineas as $l) {
    $resultado[] = [
        "texto" => trim($l),
        "emocion" => "neutral"
    ];
}

echo json_encode($resultado);