<?php

namespace App\Utils;

class Utils
{
    public static function textError($name, $value, $length)
    {
        if (strlen($value) < $length) {
            $_SESSION[$name] = "$name tiene que tener al menos $length caracteres";
            return true;
        }

        return false;
    }

    public static function numError($name, $value, $min, $max)
    {
        if ($value < $min ||  $value > $max) {
            $_SESSION[$name] = "$name tiene que tener un valor entre $min y $max";
            return true;
        }

        return false;
    }

    public static function showErrors($errorName)
    {
        if (isset($_SESSION[$errorName])) {
            echo "<p class='text-xs italic text-red-700 mt-2'>{$_SESSION[$errorName]}</p>";
            unset($_SESSION[$errorName]);
        }
    }
}
