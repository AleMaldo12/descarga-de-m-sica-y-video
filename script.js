function esURLValida(url) {
    return url.includes("youtube.com") || url.includes("youtu.be");
}

function getYouTubeID(url) {
    let regExp = /(?:youtube\.com.*v=|youtu\.be\/)([^&]+)/;
    let match = url.match(regExp);
    return match ? match[1] : null;
}

function procesarYoutube() {
    let url = document.getElementById("youtubeUrl").value;
    let formato = document.getElementById("formato").value;
    let estado = document.getElementById("estado");

    if (!esURLValida(url)) {
        alert("URL no válida");
        return;
    }

    estado.innerText = "Procesando...";

    fetch("descargar.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `url=${encodeURIComponent(url)}&formato=${formato}`
    })
    .then(res => res.text())
    .then(ruta => {
        console.log("RUTA:", ruta);

        if (ruta === "error") {
            estado.innerText = "Error al descargar";
            return;
        }

        estado.innerText = "Descarga completa";

        if (formato === "mp3") {
            let audio = document.getElementById("reproductor");
            let source = document.getElementById("sourceAudio");

            audio.style.display = "block";
            document.getElementById("videoPlayer").style.display = "none";

            source.src = ruta + "?t=" + Date.now();
            audio.load();

            audio.oncanplay = () => console.log("Audio listo");
            audio.onerror = (e) => console.error("Error audio", e);

            analizarAudio(ruta);

        } else {
            let video = document.getElementById("videoPlayer");

            video.style.display = "block";
            document.getElementById("reproductor").style.display = "none";

            video.src = ruta;
        }
    });
}

function analizarAudio(ruta) {
    console.log("Audio enviado:", ruta);

    fetch("analizar.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `audio=${encodeURIComponent(ruta)}`
    })
    .then(res => res.text()) // 🔥 CAMBIO IMPORTANTE
    .then(texto => {
        console.log("RESPUESTA PHP:", texto);

        try {
            let data = JSON.parse(texto);

            mostrarLetra(data);
            reproducirAnimacion(data);

        } catch (e) {
            console.error("❌ ERROR JSON:", e);
        }
    })
    .catch(err => {
        console.error("❌ ERROR FETCH:", err);
    });
}

function mostrarLetra(data) {
    let contenedor = document.getElementById("letra");
    contenedor.innerHTML = "";

    data.forEach(l => {
        let div = document.createElement("div");
        div.innerText = l.texto;
        contenedor.appendChild(div);
    });
}

function cambiarCara(emocion) {
    let cara = document.getElementById("caraAnimada");
    cara.classList.remove("feliz", "triste", "neutral");
    cara.classList.add(emocion);
}

function reproducirAnimacion(data) {
    let audio = document.getElementById("reproductor");
    let i = 0;

    audio.onplay = () => {
        let intervalo = setInterval(() => {
            if (i >= data.length) {
                clearInterval(intervalo);
                return;
            }

            cambiarCara(data[i].emocion);
            i++;
        }, 2000);
    };
}
console.log("Audio enviado:", ruta);