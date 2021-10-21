<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Enums\Operation;
use App\Models\UserInformation;
use App\Models\Vehicle;
use App\Processors\RiskRules\VehicleProducedAtLast5Years;
use TestCase;

class VehicleProducedAtLast5YearsTest extends TestCase
{
    public function test_validate()
    {
        $dataSet = [
            [date('Y') - 6, false],
            [date('Y') - 5, true],
            [date('Y') - 4, true]
        ];

        foreach ($dataSet as $data) {
            $vehicle = $this->createMock(Vehicle::class);
            $vehicle->method('getYear')->will($this->returnValue($data[0]));

            $ui = $this->createMock(UserInformation::class);
            $ui->method('getVehicle')->will($this->returnValue($vehicle));

            $operation = $this->createMock(Operation::class);
            $riskHandler = new VehicleProducedAtLast5Years($ui, $operation, rand(1,2));

            $this->assertEquals($data[1], $riskHandler->validate());
        }
    }
}