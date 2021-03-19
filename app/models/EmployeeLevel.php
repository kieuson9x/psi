<?php
class EmployeeLevel
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getLevelOptions()
    {
        $this->db->query('SELECT id, name FROM employee_levels');

        $results = $this->db->resultSet();

        return array_map(function ($value) {
            return [
                'value' => $value->id,
                'title' => $value->name,
            ];
        }, $results);
    }
}
