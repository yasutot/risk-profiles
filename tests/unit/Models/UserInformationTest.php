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

    public function testAgeSetterThrowsAnExceptionWhenAgeIsNegative()
    {
        $this->expectException(UserInformationException::class);

        $age = rand(-10, -1);
        $this->userInformation->setAge($age);
    }

    public function testAgeGetterAndSetter()
    {
        $age = rand(0, 10);
        $this->userInformation->setAge($age);

        $this->assertEquals($age, $this->userInformation->getAge());
    }

    public function testDependentsSetterThrowsAnExceptionWhenDependentsIsNegative()
    {
        $this->expectException(UserInformationException::class);

        $dependents = rand(-10, -1);
        $this->userInformation->setDependents($dependents);
    }

    public function testDependentsGetterAndSetter()
    {
        $dependents = rand(0, 10);
        $this->userInformation->setDependents($dependents);

        $this->assertEquals($dependents, $this->userInformation->getDependents());
    }

    public function testIncomeSetterThrowsAnExceptionWhenIncomeIsNegative()
    {
        $this->expectException(UserInformationException::class);

        $income = rand(-10, -1);
        $this->userInformation->setIncome($income);
    }

    public function testIncomeGetterAndSetter()
    {
        $income = rand(0, 10);
        $this->userInformation->setIncome($income);

        $this->assertEquals($income, $this->userInformation->getIncome());
    }

    /**
     * @testWith
     *      [[0,0,0,0], "App\\Exceptions\\UserInformationException", "Risk Questions should have 3 items."]
     *      [[0,0],     "App\\Exceptions\\UserInformationException", "Risk Questions should have 3 items."]
     *      [[1,2,3],   "App\\Exceptions\\UserInformationException", "Risk Questions items should be 0 or 1"]
     */
    public function testRiskQuestionsSetterThrowsAnExceptionWhenDataIsInvalid($riskQuestions, $exception, $message)
    {
        $this->expectException($exception);
        $this->expectExceptionMessage($message);

        $this->userInformation->setRiskQuestions($riskQuestions);
    }

    public function testMaritalStatusGetterAndSetter()
    {
        $maritalStatus = MaritalStatus::MARRIED();
        $this->userInformation->setMaritalStatus($maritalStatus);

        $this->assertEquals($maritalStatus, $this->userInformation->getMaritalStatus());
    }

    public function testHouseGetterAndSetter()
    {
        $house = $this->createMock(House::class);
        $this->userInformation->setHouse($house);

        $this->assertEquals($house, $this->userInformation->getHouse());
    }

    public function testVehicleGetterAndSetter()
    {
        $vehicle = $this->createMock(Vehicle::class);
        $this->userInformation->setVehicle($vehicle);

        $this->assertEquals($vehicle, $this->userInformation->getVehicle());
    }

    public function testRiskQuestionsGetterAndSetter()
    {
        $expectedRiskQuestions = [0, 1, 0];
        $this->userInformation->setRiskQuestions($expectedRiskQuestions);

        $riskQuestions = $this->userInformation->getRiskQuestions();

        for ($i=0; $i < count($riskQuestions); $i++) { 
            $this->assertEquals($expectedRiskQuestions[$i], $riskQuestions[$i]);
        }
    }
}
