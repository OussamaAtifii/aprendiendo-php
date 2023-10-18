<?php

class Usuario
{
    private string $username;
    private string $ciudad;
    private int $perfil;
    static int $contador = 0;

    public function __construct()
    {
        self::$contador++;
        $num = func_num_args();
        switch ($num) {
            case 0:
                break;

            case 1:
                $this->username = func_get_arg(0);
                break;

            case 3:
                $this->username = func_get_arg(0);
                $this->ciudad = func_get_arg(1);
                $this->perfil = func_get_arg(2);
                break;
        }
    }

    /**
     * Get the value of username
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Set the value of username
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of ciudad
     */
    public function getCiudad(): string
    {
        return $this->ciudad;
    }

    /**
     * Set the value of ciudad
     */
    public function setCiudad(string $ciudad): self
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get the value of perfil
     */
    public function getPerfil(): int
    {
        return $this->perfil;
    }

    /**
     * Set the value of perfil
     */
    public function setPerfil(int $perfil): self
    {
        $this->perfil = $perfil;

        return $this;
    }
}

$usuario1 = (new Usuario)
    ->setUsername("Oussama")
    ->setCiudad("Almeria")
    ->setPerfil(50);

var_dump($usuario1);

// $usuario1->setUsername("Oussama");
// $usuario1->setCiudad("Almeria");
// $usuario1->setPerfil(50);

// var_dump($usuario1);

$usuario2 = new Usuario("Victor", "Sevilla", 45);

var_dump($usuario2);
