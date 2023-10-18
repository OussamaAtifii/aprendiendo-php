<?php
class PlanFactory
{
    public function getPlan(Cliente $cliente): Plan
    {
        return match (true) {
            $cliente->totalCompras >= 50 => new PlatinoPlan,
            $cliente->totalCompras >= 40 => new OroPlan,
            $cliente->totalCompras >= 20 => new PlataPlan,
            default => new BroncePlan
        };
    }
}
