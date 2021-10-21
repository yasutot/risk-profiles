<?php

namespace App\Models;

use App\Enums\MaritalStatus;
use App\Exceptions\UserInformationException;

class UserInformation
{
    protected int $age;
    protected int $dependents;
    protected int $income;
    protected array $riskQuestions;
    protected MaritalStatus $maritalStatus;
    protected ?House $house = null;
    protected ?Vehicle $vehicle = null;

    public function setAge(int $age): void
    {
        if ($age < 0) {
            throw new UserInformationException();
        }

        $this->age = $age;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setDependents(int $dependents): void
    {
        if ($dependents < 0) {
            throw new UserInformationException('Dependents cannot be negative.');
        }

        $this->dependents = $dependents;
    }

    public function getDependents(): int
    {
        return $this->dependents;
    }

    public function setIncome(int $income): void
    {
        if ($income < 0) {
            throw new UserInformationException('Income cannot be negative.');
        }

        $this->income = $income;
    }

    public function getIncome(): int
    {
        return $this->income;
    }

    public function setRiskQuestions(array $riskQuestions): void
    {
        $this->validateRiskQuestions($riskQuestions);

        $this->riskQuestions = $riskQuestions;
    }

    public function getRiskQuestions(): array
    {
        return $this->riskQuestions;
    }

    public function setMaritalStatus(MaritalStatus $maritalStatus): void
    {
        $this->maritalStatus = $maritalStatus;
    }

    public function getMaritalStatus(): MaritalStatus
    {
        return $this->maritalStatus;
    }

    public function setHouse(House $house): void
    {
        $this->house = $house;
    }

    public function getHouse(): ?House
    {
        return $this->house;
    }

    public function setVehicle(Vehicle $vehicle): void
    {
        $this->vehicle = $vehicle;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    private function validateRiskQuestions(array $riskQuestions)
    {
        if (count($riskQuestions) !== 3) {
            throw new UserInformationException('Risk Questions should have 3 items.');
        }

        $invalidValues = array_filter($riskQuestions, function ($item) {
            return $item !== 0 && $item !== 1;
        });

        if (empty($invalidValues) === false) {
            throw new UserInformationException('Risk Questions items should be 0 or 1.');
        }
    }
}