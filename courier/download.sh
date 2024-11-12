#!/bin/bash

# Tomar los parámetros
URL="$1"
CARPETA_DESTINO="$2"
NOMBRE_ARCHIVO="$3"

# Ejecutar wget para descargar el archivo
wget -q -O "$CARPETA_DESTINO/$NOMBRE_ARCHIVO" "$URL"

# Verificar si wget se ejecutó correctamente
if [ $? -eq 0 ]; then
  echo "Archivo descargado correctamente en '$CARPETA_DESTINO/$NOMBRE_ARCHIVO'."
else
  echo "Error al intentar descargar el archivo."
  exit 1
fi