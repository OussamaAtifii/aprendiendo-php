<?php

require "./Persona.php";
class Empleado extends Persona
{
    private string $sucursal;

    public function __construct($nombre, $edad, $cargo, $sucursal)
    {
        parent::__construct($nombre, $edad, $cargo);
        $this->sucursal = $sucursal;
    }

    public function __toString(): string
    {
        return parent::__toString() . " " . $this->sucursal;
    }
}

$empleado = new Empleado("Oussama", 34, "Becario", "Almeria");
var_dump($empleado);
