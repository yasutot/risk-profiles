<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Models\UserInformation;
use App\Processors\Operations\Operation;
use App\Processors\RiskRules\AgeHigherThan60;
use TestCase;

class AgeHigherThan60Test extends TestCase
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
     *      [59, false]
     *      [60, false]
     *      [61, true]
     */
    public function testValidate($input, $expected)
    {
        $this->userInformation->method('getAge')->will($this->returnValue($input));

        $riskRuleHandler = new AgeHigherThan60($this->userInformation, $this->operation);

        $this->assertEquals($expected, $riskRuleHandler->validate());
    }
}