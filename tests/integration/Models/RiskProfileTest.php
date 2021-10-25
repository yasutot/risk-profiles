<?php

namespace Test\Integration\Models;

use App\Enums\InsurancePlanValue;
use App\Factories\UserInformationFactory;
use App\Models\RiskProfile;
use TestCase;

class RiskProfileTest extends TestCase
{
    public RiskProfile $riskProfile;

    public function setUp(): void
    {
        $this->riskProfile = new RiskProfile($this->createUserInformation());
    }

    public function testGetInsurancePlan()
    {
        $this->assertInstanceOf(InsurancePlanValue::class, $this->riskProfile->getAutoInsurancePlan());
        $this->assertInstanceOf(InsurancePlanValue::class, $this->riskProfile->getDisabilityInsurancePlan());
        $this->assertInstanceOf(InsurancePlanValue::class, $this->riskProfile->getHomeInsurancePlan());
        $this->assertInstanceOf(InsurancePlanValue::class, $this->riskProfile->getLifeInsurancePlan());
    }

    private function createUserInformation()
    {
        return UserInformationFactory::createFromArray([
            'age' => 41,
            'dependents' => 3,
            'income' => 10000,
            'marital_status' => 'single',
            'house_ownership' => ['status' => 'owned'],
            'risk_questions' => [1, 1, 1],
            'vehicle' => [
                'year' => date('Y')
            ],
            'house' => [
                'ownership_status' => 'owned'
            ]
        ]);
    }
}