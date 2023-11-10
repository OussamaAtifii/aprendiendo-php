<?php

namespace App\Utils;

const MAY_ON = true;
const MAY_OFF = false;

class Utils
{
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
            return  false;
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
}
