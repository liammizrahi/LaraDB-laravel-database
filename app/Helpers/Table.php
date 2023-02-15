<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class Table
{
    private string $name;
    private array $structure;
    private array $data;
    private string $path;

    public function __construct($tableName, $structure = [], $data = [])
    {
        if(!$tableName) {
            throw new \Exception('Table name is required');
        }

        $this->path = 'tables/' . $tableName . '.json';

        if (Storage::exists($this->path)) {
            // Get the current data from existing table
            $json = Storage::get($this->path);
            $data = json_decode($json, true);

            $this->name = $tableName;
            $this->structure = $data['structure'];
            $this->data = $data['data'];
        }
        else {
            // Create a new table and save it to a file
            $this->name = $tableName;
            $this->structure = $structure;
            $this->data = $data;

            $this->save();
        }
    }

    private function save() {
        // The the data stored in the class as json file
        Storage::put($this->path, json_encode([
            'structure' => $this->structure,
            'data' => $this->data
        ]));
    }

    public function insert($data)
    {
        // Check if the data has the same structure as the table
        foreach($data as $key => $value) {
            if(!in_array($key, $this->structure)) {
                throw new \Exception('Invalid column name: ' . $key);
            }
        }

        $this->data[] = $data;
        $this->save();
    }

    public function update($id, $data)
    {
        // Run on every column we want to update in the row
        foreach($data as $key => $value) {
            // In case that the key is not in the structure
            if(!in_array($key, $this->structure)) {
                throw new \Exception('Invalid column name: ' . $key);
            }

            $this->data[$id][$key] = $value;
        }
        $this->save();
    }

    public function delete($id)
    {
        unset($this->data[$id]);
        $this->save();
    }

    public function get($id)
    {
        if(!array_key_exists($id, $this->data)) {
            throw new \Exception('Invalid row id: ' . $id);
        }
        return $this->data[$id];
    }

    public function getAll()
    {
        return $this->data;
    }

    public function drop()
    {
        $this->data = [];
        $this->save();
        //Storage::delete($this->path);
    }

    public function getStructure()
    {
        return $this->structure;
    }
}
