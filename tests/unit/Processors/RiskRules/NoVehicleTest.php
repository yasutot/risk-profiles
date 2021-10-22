<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Models\UserInformation;
use App\Models\Vehicle;
use App\Processors\Operations\Operation;
use App\Processors\RiskRules\NoVehicle;
use TestCase;

class NoVehicleTest extends TestCase
{
    protected $userInformation;
    protected $operation;

    public function setUp(): void
    {
        $this->userInformation = $this->createMock(UserInformation::class);
        $this->operation = $this->createMock(Operation::class);
    }

    /**
     * @dataProvider dataset
     */
    public function testValidate($input, $expected)
    {
        $this->userInformation->method('getVehicle')->will($this->returnValue($input));

        $riskHandler = new NoVehicle($this->userInformation, $this->operation, rand(1,2));

        $this->assertEquals($expected, $riskHandler->validate());
    }

    public function dataSet()
    {
        $vehicle = $this->createMock(Vehicle::class);

        return [
            [null, true],
            [$vehicle, false],
        ];
    }
}