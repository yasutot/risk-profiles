<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Enums\HouseOwnershipStatus;
use App\Enums\Operation;
use App\Models\House;
use App\Models\UserInformation;
use App\Processors\RiskRules\HouseIsMortgaged;
use TestCase;

class HouseIsMortgagedTest extends TestCase
{
    public function test_validate()
    {
        $dataSet = [
            [HouseOwnershipStatus::MORTGAGED(), true],
            [HouseOwnershipStatus::OWNED(), false]
        ];

        foreach ($dataSet as $data) {
            $house = $this->createMock(House::class);
            $house->method('getOwnershipStatus')
                ->will($this->returnValue($data[0]));

            $ui = $this->createMock(UserInformation::class);
            $ui->method('getHouse')
                ->will($this->returnValue($house));

            $operation = $this->createMock(Operation::class);
            $riskRuleHandler = new HouseIsMortgaged($ui, $operation, rand(1,2));

            $this->assertEquals($data[1], $riskRuleHandler->validate());
        }
    }
}