<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Models\UserInformation;
use App\Models\Vehicle;
use App\Processors\Operations\Operation;
use App\Processors\RiskRules\NoVehicle;
use App\Processors\RiskRules\VehicleProducedAtLast5Years;
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

        $riskHandler = new NoVehicle($this->userInformation, $this->operation);

        $this->assertEquals($expected, $riskHandler->validate());
    }

    public function testValidateWhenUserInformationHasNoVehicle()
    {
        $this->userInformation->method('getVehicle')->will($this->returnValue(null));

        $riskRuleHandler = new VehicleProducedAtLast5Years($this->userInformation, $this->operation);

        $this->assertEquals(false, $riskRuleHandler->validate());
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