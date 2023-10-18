<?php

function mostrarError(string $txt): void
{
    echo "<p style='color:red'>$txt</p>";
}

function mostrarSolucion(int $a, int $b, int $c, string $txt)
{
    echo "La solucion de $a x<sup>2</sup> +$b x $c = 0 es: " . $txt;
}

function validarDatos(float $a, string $b, string $c): bool
{
    if ($a == 0) {
        mostrarError("$a tiene que ser numerico y distinto de 0.");
        return false;
    }

    if (!is_numeric($a) || !is_numeric($c)) {
        mostrarError("$b y/o $c tienen que ser numericos");
        return false;
    }

    return true;
}

function calcularEcuacion($a, $b, $c)
{
    $discriminante = ($b * $b) - (4 * $a * $c);

    if ($discriminante < 0) {
        mostrarSolucion($a, $b, $c, "No tiene solucion!!");
        return;
    } else {
        $solucion1 = (-1 * $b - sqrt($discriminante)) / (2 * $a);
        $solucion2 = (-1 * $b + sqrt($discriminante)) / (2 * $a);
    }

    mostrarSolucion($a, $b, $c, "$solucion1, $solucion2");
}

if (isset($_GET["a"]) && isset($_GET["b"]) && isset($_GET["c"])) {
    $a = (float)$_GET["a"];
    $c = $_GET["c"];
    $b = $_GET["b"];

    if (validarDatos($a, $b, $c)) {
        $b = (float) $b;
        $c = (float) $c;
        calcularEcuacion($a, $b, $c);
    }
} else {
    mostrarError("Faltan los parámetros.");
}
