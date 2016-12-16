<?php

namespace AppBundle\Repository;


class DataRepository
{
    public static function readData()
    {
        return json_decode(file_get_contents('../var/cache/data.json'));
    }

    public static function writeData($data)
    {
        if (is_array($data)) {
            file_put_contents('../var/cache/data.json', json_encode($data));
            return true;
        }
        return false;
    }
}
