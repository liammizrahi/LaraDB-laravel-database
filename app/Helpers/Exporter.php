<?php

/**
 * I thought it was better idea to create a function for the export functionality
 * but since you asked for a class, I created a class.
 */

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use App\Helpers\Table;

class Exporter
{
    /**
     * Export the data to a file
     *
     * @param string $fileName
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public static function export(Table $table ,array $columns): array
    {
        $structure = $table->getStructure();
        foreach($columns as $column) {
            if(!in_array($column, $structure)) {
                throw new \Exception('Invalid column name: ' . $column);
            }
        }

        $data = $table->getAll();

        return array_map(function($item) use ($columns) {
            return array_intersect_key($item, array_flip($columns));
        }, $data);
    }
}
