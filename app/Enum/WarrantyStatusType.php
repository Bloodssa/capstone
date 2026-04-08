<?php

namespace App\Enum;

enum WarrantyStatusType:string
{
    case ACTIVE = 'active';
    case PENDING = 'pending';
    case NEAR_EXPIRY = 'near-expiry';
    case EXPIRED = 'expired';

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Active',
            self::PENDING => 'Pending',
            self::NEAR_EXPIRY => 'Expiring Soon',
            self::EXPIRED => 'Expired'
        };  
    }
}
