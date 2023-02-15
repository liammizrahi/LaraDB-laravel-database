<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use App\Helpers\Table;
use App\Helpers\Exporter;

class Database
{
    private array $tables = [];

    public function __construct()
    {
        // take the json files from the storage folder
        $jsonFiles = File::glob(storage_path('tables/*.json'));

        foreach ($jsonFiles as $jsonFile) {
            $json = File::get($jsonFile);
            $data = json_decode($json, true);
            $tableName = basename($jsonFile, '.json');

            $this->tables[$tableName] = new Table($tableName, $data['structure'], $data['data']);
        }
    }

    public function createTable($tableName, $structure = [])
    {
        if(!$tableName) {
            throw new \Exception('Table name is required');
        }

        if (array_key_exists($tableName, $this->tables)) {
            throw new \Exception('Table already exists');
        }

        $this->tables[$tableName] = new Table($tableName, $structure);
    }

    private function getTable($tableName)
    {
        if(!$tableName) {
            throw new \Exception('Table name is required');
        }

        if (!array_key_exists($tableName, $this->tables)) {
            throw new \Exception('Table does not exist');
        }

        return $this->tables[$tableName];
    }

    public function insert($tableName, $data)
    {
        $table = $this->getTable($tableName);
        $table->insert($data);
    }

    public function update($tableName, $id, $data)
    {
        $table = $this->getTable($tableName);
        $table->update($id, $data);
    }

    public function delete($tableName, $id)
    {
        $table = $this->getTable($tableName);
        $table->delete($id);
    }

    public function select($tableName, $id)
    {
        $table = $this->getTable($tableName);
        return $table->get($id);
    }

    public function selectAll($tableName)
    {
        $table = $this->getTable($tableName);
        return $table->getAll();
    }

    public function dropTable($tableName)
    {
        $table = $this->getTable($tableName);
        $table->drop();
    }

    public function exportTableByColumns($tableName, $columns)
    {
        $table = $this->getTable($tableName);
        return Exporter::export($table, $columns);
    }

}
