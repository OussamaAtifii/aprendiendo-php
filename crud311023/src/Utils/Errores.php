<?php

namespace App\Utils;

const MAYUS_ON = 0;
const MAYUS_OFF = 1;

class Errores
{
    public static array $tiposImagen = [
        "image/gif",
        "image/png",
        "image/jpg",
        "image/jpeg",
        "image/bmp",
        "image/webp",
        "image/svg+xml",
        "image/x-icon"
    ];

    public static function errorTexto(string $nombre, string $valor, int $longitud): bool
    {
        if (strlen($valor) < $longitud) {
            $_SESSION[$nombre] = "El campo $nombre debe tener al menos $longitud caracteres";
            return true;
        }

        return false;
    }

    public static function errorNum(string $nombre, string $valor, int $min, int $max): bool
    {
        if ($valor < $min || $valor >= $max) {
            $_SESSION[$nombre] = "El campo $nombre debe estar entre $min y $max";
            return true;
        }

        return false;
    }

    public static function sanearCampos(string $campo, int $mode = MAYUS_ON): string
    {
        return $mode === MAYUS_ON
            ? ucfirst(htmlspecialchars(trim($campo)))
            : htmlspecialchars(trim($campo));
    }

    public static function mostrarErrores(string $nombre)
    {
        if (isset($_SESSION[$nombre])) {
            echo "<p class='text-sm text-red-700 italic mt-2'>{$_SESSION[$nombre]}</p>";
            unset($_SESSION[$nombre]);
        }
    }

    public static function errorImagen(string $type, int $size): bool
    {
        if (!in_array($type, self::$tiposImagen)) {
            $_SESSION['Imagen'] = "Error, el archivo debe ser una imagen";
            return true;
        }

        if ($size > 2000000) { // 2MB
            $_SESSION['Imagen'] = "Error, el archivo excede los 2 MB permitidos";
            return true;
        }

        return false;
    }
}
