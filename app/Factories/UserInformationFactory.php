<?php

namespace App\Factories;

use App\Enums\HouseOwnershipStatus;
use App\Enums\MaritalStatus;
use App\Models\House;
use App\Models\UserInformation;
use App\Models\Vehicle;

class UserInformationFactory
{
    public static function createFromArray($data): UserInformation
    {
        $userInformation = new UserInformation();

        $dataHasHouseOwnershipStatus = array_key_exists('house', $data)
                                       && array_key_exists('ownership_status', $data['house']);
        if ($dataHasHouseOwnershipStatus) {
            $ownershipStatus = HouseOwnershipStatus::from($data['house']['ownership_status']);
            $house = new House($ownershipStatus);
            $userInformation->setHouse($house);
        }

        $dataHasVehicleYear = array_key_exists('vehicle', $data) && array_key_exists('year', $data['vehicle']);
        if ($dataHasVehicleYear) {
            $vehicle = new Vehicle($data['vehicle']['year']);
            $userInformation->setVehicle($vehicle);
        }

        if (array_key_exists('age', $data)) {
            $userInformation->setAge($data['age']);
        }

        if (array_key_exists('dependents', $data)) {
            $userInformation->setDependents($data['dependents']);
        }

        if (array_key_exists('income', $data)) {
            $userInformation->setIncome($data['income']);
        }

        if (array_key_exists('marital_status', $data)) {
            $maritalStatus = MaritalStatus::from($data['marital_status']);

            $userInformation->setMaritalStatus($maritalStatus);
        }

        if (array_key_exists('risk_questions', $data)) {
            $userInformation->setRiskQuestions($data['risk_questions']);
        }

        return $userInformation;
    }
}
