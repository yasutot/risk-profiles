<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Enums\Operation;
use App\Models\UserInformation;
use App\Processors\RiskRules\AgeHigherThan60;
use TestCase;

class AgeHigherThan60Test extends TestCase
{
    public function test_validate()
    {
        $dataSet = [
            [59, false],
            [60, false],
            [61, true]
        ];

        foreach ($dataSet as $data) {
            $ui = $this->createMock(UserInformation::class);
            $ui->method('getAge')->will($this->returnValue($data[0]));

            $operation = $this->createMock(Operation::class);
            $riskRuleHandler = new AgeHigherThan60($ui, $operation, rand(1,2));

            $this->assertEquals($data[1], $riskRuleHandler->validate());
        }
    }
}