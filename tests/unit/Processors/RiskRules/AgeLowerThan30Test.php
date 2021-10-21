<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Enums\Operation;
use App\Models\UserInformation;
use App\Processors\RiskRules\AgeLowerThan30;
use TestCase;

class AgeLowerThan30Test extends TestCase
{
    public function test_validate()
    {
        $dataSet = [
            [29, true],
            [30, false],
            [31, false]
        ];

        foreach ($dataSet as $data) {
            $ui = $this->createMock(UserInformation::class);
            $ui->method('getAge')->will($this->returnValue($data[0]));

            $operation = $this->createMock(Operation::class);
            $riskRuleHandler = new AgeLowerThan30($ui, $operation, rand(1,2));

            $this->assertEquals($data[1], $riskRuleHandler->validate());
        }
    }
}