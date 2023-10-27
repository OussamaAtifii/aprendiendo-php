<?php

namespace Src\Utils;

use Src\Models\Usuario;

class Errores
{
    public static function hayErrorCampo($valor, $longitud): bool
    {
        return (strlen($valor) < $longitud);
    }

    public static function emailValido(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return !Usuario::existeEmail($email);
    }

    public static function errorProvincia($provincia): bool
    {
        return !in_array($provincia, Provincias::$misProvincias);
    }

    public static function pintarError(string $nombre)
    {
        if (isset($_SESSION[$nombre])) {
            echo "<p class='text-red-600 text-sm italic mt-2'>{$_SESSION[$nombre]}</p>";
            unset($_SESSION[$nombre]);
        }
    }
}
