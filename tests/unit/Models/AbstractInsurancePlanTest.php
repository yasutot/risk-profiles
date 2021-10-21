<?php

namespace Tests\Unit\Models;

use App\Models\AbstractInsurancePlan;
use App\Models\UserInformation;
use TestCase;

class StubInsurancePlan extends AbstractInsurancePlan {}

class AbstractInsurancePlanTest extends TestCase
{
    public function test_construct_sets_user_information()
    {
        $ui = $this->createMock(UserInformation::class);
        $insurancePlan = new StubInsurancePlan($ui);
        $insurancePlanUserInformation = $this->getProtectedPropertyValue($insurancePlan, 'userInformation');

        $this->assertEquals($ui, $insurancePlanUserInformation);
    }

    public function test_base_value()
    {
        $dataSet = [
            [[1,1,1], 3],
            [[1,2,3], 6],
            [[0,1,0], 1]
        ];

        foreach ($dataSet as $data) {
            $ui = $this->createMock(UserInformation::class);
            $ui->method('getRiskQuestions')->will($this->returnValue($data[0]));

            $insurancePlan = new StubInsurancePlan($ui);
            $insurancePlanReflection = $this->getReflection(StubInsurancePlan::class);
            $baseValueMethod = $this->getProtectedMethod($insurancePlanReflection, 'baseValue');

            $result = $baseValueMethod->invokeArgs($insurancePlan, []);

            $this->assertEquals($data[1], $result);
        }
    }
}
