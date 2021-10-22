<?php

namespace App\Models;

use App\Processors\Operations\Add;
use App\Processors\Operations\Deny;
use App\Processors\Operations\Subtract;
use App\Processors\RiskRules\AgeLowerThan30;
use App\Processors\RiskRules\HouseIsMortgaged;
use App\Processors\RiskRules\IncomeHigherThan200K;
use App\Processors\RiskRules\NoHouse;
use App\Processors\RiskRules\NoIncome;
use App\Processors\RiskRules\NoVehicle;

class HomeInsurancePlan extends AbstractInsurancePlan
{
    protected array $rules = [
        ['rule' => NoIncome::class,             'operation' => Deny::class,     'score' => 0],
        ['rule' => NoVehicle::class,            'operation' => Deny::class,     'score' => 0],
        ['rule' => NoHouse::class,              'operation' => Deny::class,     'score' => 0],
        ['rule' => AgeLowerThan30::class,       'operation' => Subtract::class, 'score' => 2],
        ['rule' => IncomeHigherThan200K::class, 'operation' => Subtract::class, 'score' => 1],
        ['rule' => HouseIsMortgaged::class,     'operation' => Add::class,      'score' => 1],
    ];
}
