<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

enum IdiomasEnum:String {
    case Spanish = "español";
    case English = "inglés";
}

class Idiomas extends Model
{
    public static function getIdiomas(): array {
        return IdiomasEnum::cases();
    }

    public static function getFromName(string $name) {
        foreach (IdiomasEnum::cases() as $idioma) {
            if ($idioma->name === $name) {
                return $idioma;
            }
        }

        return null;
    }
}
