<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Models\House;
use App\Models\UserInformation;
use App\Processors\Operations\Operation;
use App\Processors\RiskRules\NoHouse;
use TestCase;

class NoHouseTest extends TestCase
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
        $this->userInformation->method('getHouse')->will($this->returnValue($input));

        $riskHandler = new NoHouse($this->userInformation, $this->operation);

        $this->assertEquals($expected, $riskHandler->validate());
    }

    public function dataSet()
    {
        $house = $this->createMock(House::class);

        return [
            [null, true],
            [$house, false],
        ];
    }
}