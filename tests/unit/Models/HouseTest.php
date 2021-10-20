<?php

namespace Tests\Unit\Models;

use App\Enums\HouseOwnershipStatus;
use App\Models\House;
use TestCase;

class HouseTest extends TestCase
{
    public function test_get_year_returns_the_vehicle_year()
    {
        $status = HouseOwnershipStatus::MORTGAGED();
        $house = new House($status);

        $this->assertEquals($status, $house->getOwnershipStatus());
    }
}
