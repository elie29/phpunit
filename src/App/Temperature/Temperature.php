<?php
namespace App\Temperature;

class Temperature
{

    /**
     * @var TemperatureServiceInterface
     */
    private $service;

    public function __construct(TemperatureServiceInterface $service)
    {
        $this->service = $service;
    }

    public function average()
    {
        $total = 0;
        for ($i = 0; $i < 3; $i ++) {
            $tmp = $this->service->readTemp();
            $total += $tmp;
        }
        return $total / 3;
    }
}