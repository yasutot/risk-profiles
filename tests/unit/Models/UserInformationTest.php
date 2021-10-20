<?php

namespace Tests\Unit\Models;

use App\Enums\MaritalStatus;
use App\Exceptions\UserInformationException;
use App\Models\House;
use App\Models\UserInformation;
use App\Models\Vehicle;
use TestCase;

class UserInformationTest extends TestCase
{
    private UserInformation $userInformation;

    protected function setUp(): void
    {
        $this->userInformation = new UserInformation();
    }

    public function test_age_setter_throws_an_exception_when_age_is_negative()
    {
        $this->expectException(UserInformationException::class);

        $age = rand(-10, -1);
        $this->userInformation->setAge($age);
    }

    public function test_age_getter_and_setter()
    {
        $age = rand(0, 10);
        $this->userInformation->setAge($age);

        $this->assertEquals($age, $this->userInformation->getAge());
    }

    public function test_dependents_setter_throws_an_exception_when_dependents_is_negative()
    {
        $this->expectException(UserInformationException::class);

        $dependents = rand(-10, -1);
        $this->userInformation->setDependents($dependents);
    }

    public function test_dependents_getter_and_setter()
    {
        $dependents = rand(0, 10);
        $this->userInformation->setDependents($dependents);

        $this->assertEquals($dependents, $this->userInformation->getDependents());
    }

    public function test_income_setter_throws_an_exception_when_income_is_negative()
    {
        $this->expectException(UserInformationException::class);

        $income = rand(-10, -1);
        $this->userInformation->setIncome($income);
    }

    public function test_income_getter_and_setter()
    {
        $income = rand(0, 10);
        $this->userInformation->setIncome($income);

        $this->assertEquals($income, $this->userInformation->getIncome());
    }

    public function test_risk_questions_setter_throws_an_exception_when_data_is_invalid()
    {
        $testData = [
            [[0,0,0,0], UserInformationException::class, 'Risk Questions should have 3 items.'],
            [[0,0,0],   UserInformationException::class, 'Risk Questions should have 3 items.'],
            [[1,2,3],   UserInformationException::class, 'Risk Questions items should be 0 or 1'],
        ];

        foreach ($testData as $data) {
            $this->expectException($data[1]);
            $this->expectExceptionMessage($data[2]);

            $this->userInformation->setRiskQuestions($data[0]);
        }
    }

    public function test_marital_status_getter_and_setter()
    {
        $maritalStatus = MaritalStatus::MARRIED();
        $this->userInformation->setMaritalStatus($maritalStatus);

        $this->assertEquals($maritalStatus, $this->userInformation->getMaritalStatus());
    }

    public function test_house_getter_and_setter()
    {
        $house = $this->createMock(House::class);
        $this->userInformation->setHouse($house);

        $this->assertEquals($house, $this->userInformation->getHouse());
    }

    public function test_vehicle_getter_and_setter()
    {
        $vehicle = $this->createMock(Vehicle::class);
        $this->userInformation->setVehicle($vehicle);

        $this->assertEquals($vehicle, $this->userInformation->getVehicle());
    }

    public function test_risk_questions_getter_and_setter()
    {
        $expectedRiskQuestions = [rand(0,1), rand(0,1), rand(0,1)];
        $this->userInformation->setRiskQuestions($expectedRiskQuestions);

        $riskQuestions = $this->userInformation->getRiskQuestions();

        for ($i=0; $i < count($riskQuestions); $i++) { 
            $this->assertEquals($expectedRiskQuestions[$i], $riskQuestions[$i]);
        }
    }

    public function test_validate_risk_questions_throws_an_exception_when_data_it_does_not_have_3_elements()
    {
        $this->expectException(UserInformationException::class);
        $this->expectExceptionMessage('Risk Questions should have 3 items.');

        $userInformation = $this->createMock(UserInformation::class);

        $reflection = $this->getReflection(UserInformation::class);
        $validateRiskQuestions = $this->getProtectedMethod($reflection, 'validateRiskQuestions');

        $validateRiskQuestions->invokeArgs($userInformation, [[1,1]]);
    }

    public function test_validate_risk_questions_throws_an_exception_when_data_is_invalid()
    {
        $this->expectException(UserInformationException::class);
        $this->expectExceptionMessage('Risk Questions items should be 0 or 1.');

        $userInformation = $this->createMock(UserInformation::class);

        $reflection = $this->getReflection(UserInformation::class);
        $validateRiskQuestions = $this->getProtectedMethod($reflection, 'validateRiskQuestions');

        $validateRiskQuestions->invokeArgs($userInformation, [[1,1,2]]);
    }
}
