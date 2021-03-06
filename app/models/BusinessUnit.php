<?php
class BusinessUnit
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getLevelOptions()
    {
        $this->db->query('SELECT id, name FROM business_units');

        $results = $this->db->resultSet();

        return array_map(function ($value) {
            return [
                'value' => $value->id,
                'title' => $value->name,
            ];
        }, $results);
    }
}
