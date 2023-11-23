<?php

namespace App\Utils;

use App\Db\Autores;
use App\Db\Libros;

const MAYUS_ON = true;
const MAYUS_OFF = true;
class Utils
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

    public static function sanearCadena(string $cadena, $mode = MAYUS_OFF): string
    {
        return $mode == MAYUS_ON
            ? ucfirst(htmlspecialchars(trim($cadena)))
            : htmlspecialchars(trim($cadena));
    }

    public static function isCadenaValida($nombre, $valor, $longitud): bool
    {
        if (strlen($valor) < $longitud) {
            $_SESSION[$nombre] = "El campo $nombre no puede tener menos de $longitud caracteres";
            return false;
        }

        return true;
    }

    public static function existeTitulo(string $titulo): bool
    {
        if (Libros::hayLibros($titulo)) {
            $_SESSION['Titulo'] = "Este titulo ya está en uso, introduzca otro";
            return true;
        }

        return false;
    }

    public static function pintarErrores(string $nombre): void
    {
        if (isset($_SESSION[$nombre])) {
            echo "<p class='text-red-600 mt-2 italic text-sm'>{$_SESSION[$nombre]}</p>";
            unset($_SESSION[$nombre]);
        }
    }

    public static function isAutorValid(int $id): bool
    {
        if (Autores::existeIdAutor($id)) return true;

        $_SESSION['Autor_id'] = "El autor no es válido o no esta seleccionado";
        return false;
    }

    public static function isImgValida(string $tipo, int $size)
    {
        if (!in_array($tipo, self::$tiposImagen)) {
            $_SESSION['Imagen'] = "Se esperaba un archivo de imagen";
            return false;
        }

        if ($size > 2000000) {
            $_SESSION['Imagen'] = "La imagen excede los 2MB permitidos";
            return false;
        }

        return true;
    }

    public static function existeTituloUpdate(string $titulo, int $id): bool
    {
        if (Libros::getLibroById($titulo, $id)) {
            $_SESSION['Titulo'] = "Este titulo ya está en uso, introduzca otro";
            return true;
        }

        return false;
    }
}
