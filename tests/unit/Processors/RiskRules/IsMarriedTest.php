<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Enums\MaritalStatus;
use App\Enums\Operation;
use App\Models\UserInformation;
use App\Processors\RiskRules\IsMarried;
use TestCase;

class IsMarriedTest extends TestCase
{
    public function test_validate()
    {
        $dataSet = [
            [MaritalStatus::MARRIED(), true],
            [MaritalStatus::SINGLE(), false]
        ];

        foreach ($dataSet as $data) {
            $ui = $this->createMock(UserInformation::class);
            $ui->method('getMaritalStatus')->will($this->returnValue($data[0]));

            $operation = $this->createMock(Operation::class);
            $riskRuleHandler = new IsMarried($ui, $operation, rand(1,2));

            $this->assertEquals($data[1], $riskRuleHandler->validate());
        }
    }
}