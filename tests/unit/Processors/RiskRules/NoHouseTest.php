<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Enums\Operation;
use App\Models\House;
use App\Models\UserInformation;
use App\Processors\RiskRules\NoHouse;
use TestCase;

class NoHouseTest extends TestCase
{
    public function test_validate()
    {
        $house = $this->createMock(House::class);

        $dataSet = [
            [null, true],
            [$house, false],
        ];

        foreach ($dataSet as $data) {
            $ui = $this->createMock(UserInformation::class);
            $ui->method('getHouse')->will($this->returnValue($data[0]));

            $operation = $this->createMock(Operation::class);
            $riskHandler = new NoHouse($ui, $operation, rand(1,2));

            $this->assertEquals($data[1], $riskHandler->validate());
        }
    }
}