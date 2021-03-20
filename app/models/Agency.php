<?php
class Agency
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAgenciesByAMS($empId)
    {
        $this->db->query('SELECT id, name, province FROM agencies WHERE employee_id = :employee_id');

        $this->db->bind(':employee_id', $empId);

        $results = $this->db->resultSet();

        return $results;
    }
}
