<?php

namespace Tests\Integration\Services;

use App\Enums\InsurancePlanValue;
use App\Models\RiskProfile;
use App\Services\RiskProfileService;
use TestCase;

class RiskProfileServiceTest extends TestCase
{
    public function testCreate()
    {
        $riskProfile = RiskProfileService::create($this->data());

        $this->assertInstanceOf(RiskProfile::class, $riskProfile);

        $this->assertInstanceOf(InsurancePlanValue::class, $riskProfile->getAutoInsurancePlan());

    }

    private function data()
    {
        return [
            'income' => 0,
            'house' => [
            'ownership_status' => 'owned'
            ],
            'vehicle' => [
                'year' => 2000
            ],
            'age' => 20,
            'dependents' => 5,
            'marital_status' => 'married',
            'risk_questions' => [0,1,1]
        ];
    }
}