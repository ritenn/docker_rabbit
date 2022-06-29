<?php

namespace App\Dictionary;


enum EmailStatus : int
{
    case SENDING = 1;
    case SENT = 2;
    case ERROR = 3;

    /**
     * @param int $id
     *
     * @return string|null
     */
    public static function get(int $id) : ?string
    {
        return match($id)
        {
            1 => self::SENDING->name,
            2 => self::SENT->name,
            3 => self::ERROR->name,
            default => null
        };
    }
}
