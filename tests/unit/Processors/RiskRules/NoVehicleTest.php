<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Enums\Operation;
use App\Models\UserInformation;
use App\Models\Vehicle;
use App\Processors\RiskRules\NoVehicle;
use TestCase;

class NoVehicleTest extends TestCase
{
    public function test_validate()
    {
        $vehicle = $this->createMock(Vehicle::class);

        $dataSet = [
            [null, true],
            [$vehicle, false],
        ];

        foreach ($dataSet as $data) {
            $ui = $this->createMock(UserInformation::class);
            $ui->method('getVehicle')->will($this->returnValue($data[0]));

            $operation = $this->createMock(Operation::class);
            $riskHandler = new NoVehicle($ui, $operation, rand(1,2));

            $this->assertEquals($data[1], $riskHandler->validate());
        }
    }
}