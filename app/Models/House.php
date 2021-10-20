<?php

namespace App\Models;

use App\Enums\HouseOwnershipStatus;

class House
{
    private HouseOwnershipStatus $ownershipStatus;

    public function __construct(HouseOwnershipStatus $ownershipStatus)
    {
        $this->ownershipStatus = $ownershipStatus;
    }

    public function getOwnershipStatus(): HouseOwnershipStatus
    {
        return $this->ownershipStatus;
    }
}
