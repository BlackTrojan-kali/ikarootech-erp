<?php
namespace App\Enums;

use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\Enum;

class UserRole extends Enum{
    public const ADMIN = 'admin';
    public const MAGASINIER = "magasinier";
    public const PRODUCTEUR = "producteur";
    public const COMMERCIAL = "commercial";
    
    public static function options(): array{
        return [
            self::ADMIN=>"admin",
            self::MAGASINIER=>"magasinier",
            self::PRODUCTEUR=>"producteur",
            self::COMMERCIAL => "commercial"
        ];
    }
}