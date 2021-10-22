<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Enums\HouseOwnershipStatus;
use App\Models\House;
use App\Models\UserInformation;
use App\Processors\Operations\Operation;
use App\Processors\RiskRules\HouseIsMortgaged;
use TestCase;

class HouseIsMortgagedTest extends TestCase
{
    protected $userInformation;
    protected $operation;
    protected $house;

    public function setUp(): void
    {
        $this->house = $this->createMock(House::class);
        $this->userInformation = $this->createMock(UserInformation::class);
        $this->operation = $this->createMock(Operation::class);
    }

    /**
     * @dataProvider dataset
     */
    public function testValidate($input, $expected)
    {
        $this->house->method('getOwnershipStatus')->will($this->returnValue($input));
        $this->userInformation->method('getHouse')->will($this->returnValue($this->house));

        $riskRuleHandler = new HouseIsMortgaged($this->userInformation, $this->operation, rand(1,2));

        $this->assertEquals($expected, $riskRuleHandler->validate());
    }

    public function dataSet()
    {
        return [
            [HouseOwnershipStatus::MORTGAGED(), true],
            [HouseOwnershipStatus::OWNED(), false]
        ];
    }
}