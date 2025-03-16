<?php

namespace App\Repositories;

class EstateAgentCSVRepository
{
    CONST FILEPATH = './csv/';

    public static function getAllEstateAgentCSV($filename): array
    {
        //convert csv to an array
        $csvData = array_map('str_getcsv', file(self::FILEPATH . $filename));

        //remove header
        array_shift($csvData);

        // Remove empty values as 0 is false
        return array_map(fn($row) => array_filter($row, 'strlen'), $csvData);
    }
}
