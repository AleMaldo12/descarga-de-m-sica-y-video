<?php
if (!is_dir("uploads")) {
    mkdir("uploads", 0777, true);
}

$archivo = $_FILES['audio'];

$ruta = "uploads/" . basename($archivo["name"]);

move_uploaded_file($archivo["tmp_name"], $ruta);

echo $ruta;