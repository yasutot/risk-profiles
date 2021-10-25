<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Models\UserInformation;
use App\Processors\Operations\Operation;
use App\Processors\RiskRules\IncomeHigherThan200K;
use TestCase;

class IncomeHigherThan200KTest extends TestCase
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
     *      [199999, false]
     *      [200000, false]
     *      [200001, true]
     */
    public function testValidate($input, $expected)
    {
        $this->userInformation->method('getIncome')->will($this->returnValue($input));

        $riskHandler = new IncomeHigherThan200K($this->userInformation, $this->operation);

        $this->assertEquals($expected, $riskHandler->validate());
    }
}