<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Enums\Operation;
use App\Models\UserInformation;
use App\Processors\RiskRules\AgeBetween30And40;
use TestCase;

class AgeBetween30And40Test extends TestCase
{
    public function test_validate()
    {
        $dataSet = [
            [29, false],
            [30, true],
            [31, true],
            [39, true],
            [40, true],
            [41, false],
        ];

        foreach ($dataSet as $data) {
            $ui = $this->createMock(UserInformation::class);
            $ui->method('getAge')->will($this->returnValue($data[0]));

            $operation = $this->createMock(Operation::class);
            $riskRuleHandler = new AgeBetween30And40($ui, $operation, rand(1,2));

            $this->assertEquals($data[1], $riskRuleHandler->validate());
        }
    }
}