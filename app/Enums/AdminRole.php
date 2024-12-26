<?php

namespace App\Enums;

enum AdminRole: int
{
    case ADMIN = 0;
    case CONTENT_CREATOR = 1;
    case REQUESTER = 2;

    public static function getOptions(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->name;
        }

        return $options;
    }
}
