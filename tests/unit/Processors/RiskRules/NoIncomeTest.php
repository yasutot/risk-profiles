<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Models\UserInformation;
use App\Processors\Operations\Operation;
use App\Processors\RiskRules\NoIncome;
use TestCase;

class NoIncomeTest extends TestCase
{
    protected $userInformation;
    protected $operation;

    public function setUp(): void
    {
        $this->userInformation = $this->createMock(UserInformation::class);
        $this->operation = $this->createMock(Operation::class);
    }

    /**
     * @testWith
     *      [0, true]
     *      [1, false]
     */
    public function testValidate($input, $expected)
    {
        $dataSet = [
            [0, true],
            [1, false]
        ];

        foreach ($dataSet as $data) {
            $this->userInformation->method('getIncome')->will($this->returnValue($input));

            $riskHandler = new NoIncome($this->userInformation, $this->operation, rand(1,2));

            $this->assertEquals($expected, $riskHandler->validate());
        }
    }
}