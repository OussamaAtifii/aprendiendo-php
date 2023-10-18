<?php

class Persona
{
    public function __construct(
        protected string $nombre,
        protected int $edad,
        public string $cargo
    ) {
    }

    public function __toString(): string
    {
        return $this->nombre . " " . $this->edad . " " . $this->cargo;
    }
}

$persona = new Persona("Oussama", 22, "Jefe");

var_dump($persona);
