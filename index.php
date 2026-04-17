<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>🎧 Analizador PRO</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="container">
    <h1>🎵 Analizador de Canciones</h1>

    <input type="text" id="youtubeUrl" placeholder="URL de YouTube">
    
    <select id="formato">
        <option value="mp3">MP3 (Audio)</option>
        <option value="mp4">MP4 (Video)</option>
    </select>

    <button onclick="procesarYoutube()">Procesar</button>

    <p id="estado"></p>

    <!-- AUDIO CORREGIDO -->
    <audio id="reproductor" controls>
        <source id="sourceAudio" src="" type="audio/mpeg">
    </audio>

    <video id="videoPlayer" controls width="400" style="display:none;"></video>

    <!-- Cara -->
    <div id="caraAnimada" class="neutral">
        <div class="ojo izquierdo"></div>
        <div class="ojo derecho"></div>
        <div class="boca"></div>
    </div>

    <div id="letra"></div>
</div>

<script src="script.js"></script>
</body>
</html>