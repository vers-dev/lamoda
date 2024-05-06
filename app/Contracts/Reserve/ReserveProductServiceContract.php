<?php

namespace App\Contracts\Reserve;

interface ReserveProductServiceContract
{
    public function reserveProducts(array $reservedProducts): void;
}