import whisper
import sys
import os

# FFmpeg
os.environ["PATH"] = r"C:\ffmpeg\bin;" + os.environ["PATH"]

modelo = whisper.load_model("base")

archivo = sys.argv[1]

resultado = modelo.transcribe(archivo)

print(resultado["text"])