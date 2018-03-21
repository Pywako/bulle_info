<?php
/**
 */

namespace App\Service;


class DateManager
{
    public function setDateToNow(string $dateName, $entity)
    {
        $now = new \dateTime();
        $setterName = 'set' . ucfirst($dateName) . 'Date';
        $entity->$setterName($now);
        return true;
    }

}