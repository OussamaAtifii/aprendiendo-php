<?php

namespace App\Utils;

const MAY_ON = true;
const MAY_OFF = false;

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

    public static function sanearTexto(string $cad, bool $mode = MAY_OFF): string
    {
        if ($mode) {
            return ucfirst(htmlspecialchars(trim($cad)));
        }

        return htmlspecialchars(trim($cad));
    }

    public static function validarEmail(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['email'] = "Error, el email no es válido";
            return false;
        }

        return true;
    }

    public static function validarImg(string $tipo, int $tamano): bool
    {
        if (!in_array($tipo, self::$tiposImagen)) {
            $_SESSION['Imagen'] = "Se esperaba un archivo de imagen";
            return false;
        }

        if ($tamano > 2000000) {
            $_SESSION['Imagen'] = "La imagen excede los 2MB permitidos";
            return false;
        }

        return true;
    }

    public static function mostrarErrores($nombre)
    {
        if (isset($_SESSION[$nombre])) {
            echo "<p class='text-sm italic text-red-700 mt-2'>{$_SESSION[$nombre]}</p>";
            unset($_SESSION[$nombre]);
        }
    }

    public static function validarCadena(string $nombre, string $valor, int $longitud): bool
    {
        if (strlen($valor) < $longitud) {
            $_SESSION[$nombre] = "El campo nombre tiene que tener al menos $longitud caracteres";
            return false;
        }
        return true;
    }

    public static function pintarNavBar(array $options)
    {
        echo '<ul class="flex mt-4 w-3/4 mx-auto flex-row-reverse">';
        foreach ($options as $option) {
            echo <<<TXT
                <li class="mr-6">
                    <a class="text-blue-500 hover:text-blue-800" href="{$option[0]}"><i class="{$option[2]}"></i> {$option[1]}</a>
                </li>
            TXT;
        }
        echo "</ul>";
    }
}
