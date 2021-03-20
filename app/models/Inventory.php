<?php
class Inventory
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getInventories()
    {
        $today = date('10-m-Y');
        $year = date('Y', strtotime($today));

        // $endMonth = date('m', strtotime('+3 months', strtotime($today)));
        // $endYear = date('Y', strtotime('+3 months', strtotime($today)));

        // $startMonth = date('m', strtotime($today));
        // $startYear = date('Y', strtotime($today));

        // $this->db->query("SELECT * FROM inventories WHERE DATE(CONCAT(`year`, '-', `month`, '-01')) BETWEEN '{$startYear}-{$startMonth}-01' AND '{$endYear}-{$endMonth}-15'");
        $this->db->query("SELECT ANY_VALUE(i.product_id), i.month, i.year, i.number_of_imported_goods, i.number_of_remaining_goods,
                                ANY_VALUE(p.id),p.product_code, p.name, p.model, p.business_unit_id, p.industry_id, p.product_type_id
                            FROM inventories as i
                            JOIN products as p on p.id = i.product_id
                            WHERE DATE(CONCAT(`year`, '-', `month`, '-01')) BETWEEN '{$year}-01-01' AND '{$year}-12-31'
                            GROUP BY i.product_id
                            ");

        $results = $this->db->resultSet();

        var_dump($results);

        return $results;
    }
}
