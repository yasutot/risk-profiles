<?php

namespace Tests\Unit\Processors\RiskRules;

use App\Enums\Operation;
use App\Models\UserInformation;
use App\Processors\RiskRules\IncomeHigherThan200K;
use TestCase;

class IncomeHigherThan200KTest extends TestCase
{
    public function test_validate()
    {
        $dataSet = [
            [199999, false],
            [200000, false],
            [200001, true]
        ];

        foreach ($dataSet as $data) {
            $ui = $this->createMock(UserInformation::class);
            $ui->method('getIncome')
                ->will($this->returnValue($data[0]));

            $operation = $this->createMock(Operation::class);
            $riskHandler = new IncomeHigherThan200K($ui, $operation, rand(1,2));

            $this->assertEquals($data[1], $riskHandler->validate());
        }
    }
}