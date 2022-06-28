<?php

namespace App\Dictionary;


class EmailStatus {
    const SENDING = 1;
    const SENT = 2;
    const ERROR = 3;

    /**
     * @param int $id
     *
     * @return string|null
     */
    public static function get(int $id) : ?string
    {
        $class = new \ReflectionClass(__CLASS__);
        $statuses = array_flip($class->getConstants());

        return $statuses[$id] ?? null;
    }
}
