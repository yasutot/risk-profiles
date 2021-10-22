<?php

namespace Tests\Unit\Models;

use App\Models\Vehicle;
use TestCase;

class VehicleTest extends TestCase
{
    public function testGetYearReturnsTheVehicleYear()
    {
        $year = 2000;
        $vehicle = new Vehicle($year);

        $this->assertEquals($year, $vehicle->getYear());
    }
}
