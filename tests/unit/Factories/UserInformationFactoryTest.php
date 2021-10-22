<?php

use App\Enums\MaritalStatus;
use App\Factories\UserInformationFactory;
use App\Models\UserInformation;

class UserInformationFactoryTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testCreateFromArray($input)
    {
        $userInformation = UserInformationFactory::createFromArray($input);

        $this->assertInstanceOf(UserInformation::class, $userInformation);
        $this->assertEquals($input['age'], $userInformation->getAge());
        $this->assertEquals($input['dependents'], $userInformation->getDependents());
        $this->assertEquals($input['income'], $userInformation->getIncome());
        $this->assertEquals(MaritalStatus::from($input['marital_status']), $userInformation->getMaritalStatus());
        $this->assertEquals($input['risk_questions'], $userInformation->getRiskQuestions());
        $this->assertEquals($input['vehicle']['year'], $userInformation->getVehicle()->getYear());
        $this->assertEquals($input['house']['ownership_status'], $userInformation->getHouse()->getOwnershipStatus());
    }

    public function dataProvider()
    {
        return [
            [
                [
                    'house' => [
                    'ownership_status' => 'owned'
                    ],
                    'vehicle' => [
                        'year' => 2000
                    ],
                    'age' => 20,
                    'dependents' => 5,
                    'income' => 20000,
                    'marital_status' => 'married',
                    'risk_questions' => [0,1,1]
                ]
            ]
        ];
    }
}