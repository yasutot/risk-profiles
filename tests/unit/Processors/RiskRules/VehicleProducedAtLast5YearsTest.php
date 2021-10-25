<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Models\UserInformation;
use App\Models\Vehicle;
use App\Processors\Operations\Operation;
use App\Processors\RiskRules\VehicleProducedAtLast5Years;
use TestCase;

class VehicleProducedAtLast5YearsTest extends TestCase
{
    protected $userInformation;
    protected $operation;
    protected $vehicle;

    public function setUp(): void
    {
        $this->userInformation = $this->createMock(UserInformation::class);
        $this->operation = $this->createMock(Operation::class);
        $this->vehicle = $this->createMock(Vehicle::class);
    }

    /**
     * @dataProvider dataset
     */
    public function testValidate($input, $expected)
    {
        $this->vehicle->method('getYear')->will($this->returnValue($input));
        $this->userInformation->method('getVehicle')->will($this->returnValue($this->vehicle));

        $riskHandler = new VehicleProducedAtLast5Years($this->userInformation, $this->operation);

        $this->assertEquals($expected, $riskHandler->validate());
    }


    public function dataSet()
    {
        return [
            [date('Y') - 6, false],
            [date('Y') - 5, true],
            [date('Y') - 4, true]
        ];
    }
}