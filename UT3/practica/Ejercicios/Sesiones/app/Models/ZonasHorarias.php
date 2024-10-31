<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

enum ZonasHorariasEnum:String {
    case GMTMin1 = "GMT-1";
    case GMTMin2 = "GMT-2";
    case GMTPlush1 = "GMT+1";
    case GMTPlush2 = "GMT+2";

}

class ZonasHorarias extends Model
{
    public static function getZonasHorarias() {
        return ZonasHorariasEnum::cases();
    }

    public static function getFromName(string $name) {
        foreach (ZonasHorariasEnum::cases() as $zona) {
            if ($zona->name === $name) {
                return $zona;
            }
        }

        return null;
    }
}
