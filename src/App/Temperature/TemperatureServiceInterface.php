<?php
namespace App\Temperature;

interface TemperatureServiceInterface
{

    public function readTemp(): int;
}
