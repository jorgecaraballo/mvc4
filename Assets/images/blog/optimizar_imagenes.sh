#!/bin/bash
ORIGEN="/home/jorge/disk/disk/backups_importantes/2025/Marzo/199/www/ccr/blog/images"
DESTINO="/var/www/mvc4/Assets/images/blog"

mkdir -p "$DESTINO"

for img in "$ORIGEN"/*.{jpg,jpeg,png,JPG,JPEG,PNG}; do
    [ -e "$img" ] || continue
    filename=$(basename "$img")
    name="${filename%.*}"
    destino_final="$DESTINO/$name.webp"
    
    echo -n "Convirtiendo $filename... "
    # -q 80: Calidad. -m 6: Máxima compresión. -metadata none: Limpia EXIF.
    cwebp -q 80 -m 6 -metadata none "$img" -o "$destino_final" 2>/dev/null
    
    if [ $? -eq 0 ]; then
        echo "[OK]"
    else
        echo "[FALLÓ]"
    fi
done
echo "--- Proceso terminado ---"
