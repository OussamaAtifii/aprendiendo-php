<?php

namespace src\backend;

class Users
{
    public function __construct(private $nombre)
    {
        echo "<br> Soy un usuario de backend";
    }
}
