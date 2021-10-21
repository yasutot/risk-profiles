<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Enums\Operation;
use App\Models\UserInformation;
use App\Processors\RiskRules\HasDependents;
use TestCase;

class HasDependentsTest extends TestCase
{
    public function test_validate()
    {
        $dataSet = [
            [0, false],
            [1, true],
            [2, true]
        ];

        foreach ($dataSet as $data) {
            $ui = $this->createMock(UserInformation::class);
            $ui->method('getDependents')->will($this->returnValue($data[0]));

            $operation = $this->createMock(Operation::class);
            $riskRuleHandler = new HasDependents($ui, $operation, rand(1,2));

            $this->assertEquals($data[1], $riskRuleHandler->validate());
        }
    }
}