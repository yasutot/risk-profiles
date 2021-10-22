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
        ['rule' => AgeHigherThan60::class,      'operation' => Deny::class,     'score' => 0],
        ['rule' => AgeLowerThan30::class,       'operation' => Subtract::class, 'score' => 2],
        ['rule' => IncomeHigherThan200K::class, 'operation' => Subtract::class, 'score' => 1],
        ['rule' => HasDependents::class,        'operation' => Add::class,      'score' => 1],
        ['rule' => IsMarried::class,            'operation' => Add::class,      'score' => 1]
    ];
}
