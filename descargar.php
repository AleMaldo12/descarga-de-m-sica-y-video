<?php

$url = $_POST['url'] ?? '';
$formato = $_POST['formato'] ?? 'mp3';

if (!filter_var($url, FILTER_VALIDATE_URL)) {
    echo "error";
    exit;
}

if (!preg_match("/(youtube\.com|youtu\.be)/", $url)) {
    echo "error";
    exit;
}

if (!is_dir("uploads")) {
    mkdir("uploads", 0777, true);
}

$nombre = "uploads/media_" . time();

$ytdlp = "C:\\Users\\Tepo\\AppData\\Roaming\\Python\\Python313\\Scripts\\yt-dlp.exe";
$ffmpeg = "C:\\ffmpeg\\bin";

if ($formato === "mp3") {

    $comando = "\"$ytdlp\" --js-runtimes node -f bestaudio --extract-audio --audio-format mp3 --ffmpeg-location \"$ffmpeg\" -o \"$nombre.%(ext)s\" \"$url\" 2>&1";

} else {

    $comando = "\"$ytdlp\" --js-runtimes node -f mp4 --ffmpeg-location \"$ffmpeg\" -o \"$nombre.%(ext)s\" \"$url\" 2>&1";
}

exec($comando, $output, $return_var);

// Buscar archivo real generado
$archivo = glob($nombre . ".*");

if ($archivo && file_exists($archivo[0])) {
    echo str_replace("\\", "/", $archivo[0]);
} else {
    echo "error";
}