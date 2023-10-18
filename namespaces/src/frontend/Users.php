<?php

namespace src\frontend;

class Users
{
    public function __construct(private $nombre)
    {
        echo "<br> Soy un usuario de frontend";
    }
}
