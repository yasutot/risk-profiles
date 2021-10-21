<?php

namespace Tests\Unit\Models;

use App\Enums\HouseOwnershipStatus;
use App\Models\House;
use TestCase;

class HouseTest extends TestCase
{
    public function testGetOwnershipStatus()
    {
        $status = HouseOwnershipStatus::MORTGAGED();
        $house = new House($status);

        $this->assertEquals($status, $house->getOwnershipStatus());
    }
}
