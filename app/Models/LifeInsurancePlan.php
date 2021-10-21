<?php

namespace App\Models;

use App\Processors\Operations\Add;
use App\Processors\Operations\Deny;
use App\Processors\Operations\Subtract;
use App\Processors\RiskRules\AgeHigherThan60;
use App\Processors\RiskRules\AgeLowerThan30;
use App\Processors\RiskRules\HasDependents;
use App\Processors\RiskRules\IncomeHigherThan200K;
use App\Processors\RiskRules\IsMarried;

class LifeInsurancePlan extends AbstractInsurancePlan
{
    protected array $rules = [
        [AgeHigherThan60::class,      Deny::class,     0],
        [AgeLowerThan30::class,       Subtract::class, 2],
        [IncomeHigherThan200K::class, Subtract::class, 1],
        [HasDependents::class,        Add::class,      1],
        [IsMarried::class,            Add::class,      1]
    ];
}
