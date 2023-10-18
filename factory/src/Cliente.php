<?php
class Cliente
{
    public readonly int $totalCompras;

    public function __construct($total)
    {
        $this->totalCompras = $total;
    }
}
