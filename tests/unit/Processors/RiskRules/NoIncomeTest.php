<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Enums\Operation;
use App\Models\UserInformation;
use App\Processors\RiskRules\NoIncome;
use TestCase;

class NoIncomeTest extends TestCase
{
    public function test_validate()
    {
        $dataSet = [
            [0, true],
            [1, false]
        ];

        foreach ($dataSet as $data) {
            $ui = $this->createMock(UserInformation::class);
            $ui->method('getIncome')->will($this->returnValue($data[0]));

            $operation = $this->createMock(Operation::class);
            $riskHandler = new NoIncome($ui, $operation, rand(1,2));

            $this->assertEquals($data[1], $riskHandler->validate());
        }
    }
}