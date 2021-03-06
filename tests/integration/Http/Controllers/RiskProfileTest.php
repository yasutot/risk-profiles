<?php

namespace Test\Integration\Http\Controllers;

use App\Enums\HouseOwnershipStatus;
use App\Enums\InsurancePlanValue;
use App\Enums\MaritalStatus;
use TestCase;

class RiskProfileTest extends TestCase
{
    public function testCreate()
    {
        $response = $this->json('POST', 'api/v1/risk-profiles', $this->requestBody())->response->getContent();

        $this->seeStatusCode(201);
        $this->seeJsonStructure(['auto', 'life', 'disability', 'home']);
        $this->seeJson();

        $responseBody = json_decode($response);

        $this->assertEquals($responseBody->auto, 'regular');
        $this->assertEquals($responseBody->disability, 'ineligible');
        $this->assertEquals($responseBody->home, 'economic');
        $this->assertEquals($responseBody->life, 'regular');
    }

    public function testCreateWhenBodyIsEmpty()
    {
        $this->json('POST', 'api/v1/risk-profiles', []);

        $this->seeStatusCode(422);
        $this->seeJsonStructure(['errors']);
        $this->seeJsonContains([
            'age' => ['The age field is required.'],
            'dependents' => ['The dependents field is required.'],
            'income' => ['The income field is required.'],
            'marital_status' => ['The marital status field is required.'],
            'risk_questions' => ['The risk questions field is required.']
        ]);
    }

    /**
     * @testWith
     *      [{"age": -1}, ["The age must be at least 0."]]
     *      [{"age": "foo"}, ["The age must be an integer."]]
     *      [{"dependents": -1}, ["The dependents must be at least 0."]]
     *      [{"dependents": "foo"}, ["The dependents must be an integer."]]
     *      [{"income": -1}, ["The income must be at least 0."]]
     *      [{"income": "foo"}, ["The income must be an integer."]]
     *      [{"house": {"ownership_status": "foo"}}, ["The selected house.ownership status is invalid."]]
     *      [{"risk_questions": []}, ["The risk questions field is required."]]
     *      [{"risk_questions": [1]}, ["The risk questions must have at least 3 items."]]
     *      [{"risk_questions": [1,1,1,1]}, ["The risk questions may not have more than 3 items."]]
     *      [{"risk_questions": [2,0,0]}, ["The risk_questions.0 may not be greater than 1."]]
     *      [{"risk_questions": [0,0,-1]}, ["The risk_questions.2 must be at least 0."]]
     *      [{"vehicle": {"year": 0}}, ["The vehicle.year must be 4 digits."]]
     *      [{"vehicle": {"year": "foo"}}, ["The vehicle.year must be an integer."]]
     *      [{"house": {"ownership_status": "foo"}}, ["The selected house.ownership status is invalid."]]
     */
    public function testCreateWhenBodyIsInvalid($modifiers, $expected)
    {
        $data = $this->requestBody($modifiers);

        $this->json('POST', 'api/v1/risk-profiles', $data);
        $this->seeJsonContains($expected);
    }

    public function requestBody(array $modifiers = null)
    {
        $body = [
            'age' => 35,
            'dependents' => 2,
            'house' => ['ownership_status' => 'owned'],
            'income' => 0,
            'marital_status' => 'married',
            'risk_questions' => [0, 1, 0],
            'vehicle' => ['year' => 2018]
        ];

        if ($modifiers === null) {
            return $body;
        }

        return array_merge($body, $modifiers);
    }
}
