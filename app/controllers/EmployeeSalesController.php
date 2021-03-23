<?php
class EmployeeSalesController extends Controller
{
    private $db;
    public function __construct()
    {
        $this->employeeSaleModel = $this->model('EmployeeSale');
        $this->agencyModel = $this->model('Agency');
        $this->inventoryModel = $this->model('Inventory');

        $this->initEmployeeLevelOptions();
        $this->initBusinessUnitOptions();
        $this->initIndustryOptions();
        $this->initProductTypeOptions();
        $this->initAgencyOptionsByASM();
    }

    public function index()
    {
        $data = [];
        $year = (int) ($_GET['year'] ?? date('Y'));
        $data['year'] = $year;

        $employeeId = $_SESSION['user_id'] ?? null;

        if ($employeeId) {
            $year = $data['year'] ?? date('Y');
            $agencies = array_column($this->agencyModel->getAgenciesByAMS($employeeId), 'id');

            $agencySales = $this->employeeSaleModel->getAgencySales($agencies, $year);

            $data['agency_sales'] = $agencySales;
        }

        $this->view('employees/sales', $data);
    }

    public function update()
    {

        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
            $data = [
                'month' => (int) $this->data_get($_POST, 'name'),
                'value' => (int) trim($this->data_get($_POST, 'value')),
                'product_id' => (int) trim($this->data_get($_POST, 'pk')),
                'year' => (int) trim($this->data_get($_POST, 'year')),
                'state' => trim($this->data_get($_POST, 'state')),
                'agency_id' => $this->data_get($_POST, 'agency_id')
            ];

            if ($data['state'] === 'sale') {
                $data['number_of_sale_goods'] = $data['value'];
            }

            // if ($data['state'] === 'inventory') {
            //     $data['number_of_remaining_goods'] = $data['value'];
            // }

            $agencySale = $this->employeeSaleModel->findAgencySale($data['agency_id'], $data['product_id'], $data['month'], $data['year']);

            if ($agencySale) {
                $updateStatus = $this->employeeSaleModel->updateAgencySale($agencySale->id, $data);
            } else {
                $createStatus = $this->employeeSaleModel->createAgencySale($data['agency_id'], $data);
            }

            $this->syncYear($data);
            echo json_encode(['success' => true]);

            // if ($this->employeeSaleModel->updateOrcreateEmployeeSale($data)) {
            //     echo json_encode(['success' => true]);
            // } else {
            //     die("Something went wrong, please try again!");
            // }
        }
    }

    public function create()
    {
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
            $data = [
                'months' => $this->data_get($_POST, 'months'),
                'product_id' => (int) $this->data_get($_POST, 'product_id'),
                'year' => (int) $this->data_get($_POST, 'year'),
                'number_of_sale_goods' => $this->data_get($_POST, 'number_of_sale_goods'),
                'agency_id' =>  $this->data_get($_POST, 'agency_id')
                // 'number_of_remaining_goods' => $this->data_get($_POST, 'number_of_remaining_goods'),
            ];

            $updateStatus = true;
            $createStatus = true;
            foreach ($data['months'] as $month) {
                $agencySale = $this->employeeSaleModel->findAgencySale($data['agency_id'], $data['product_id'], $month, $data['year']);

                $data['month'] = $month;

                if ($agencySale) {
                    $updateStatus = $this->employeeSaleModel->updateAgencySale($agencySale->id, $data);
                } else {
                    $createStatus = $this->employeeSaleModel->createAgencySale($data['agency_id'], $data);
                }
            }

            $this->syncYear($data);

            if ($updateStatus || $createStatus) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
            // if ($this->employeeSaleModel->updateOrcreateEmployeeSale($data)) {
            //     echo json_encode(['success' => true]);
            // } else {
            //     die("Something went wrong, please try again!");
            // }
        }
    }

    public function sync($data)
    {
        $month = $data['month'];
        $year = $data['year'];

        $inventory = $this->inventoryModel->findInventory($data['product_id'], $data['month'], $data['year']);

        if (!$inventory) {
            $this->inventoryModel->createInventory($data);
            $inventory = $this->inventoryModel->findInventory($data['product_id'], $data['month'], $data['year']);
        }

        $totalSales = $this->employeeSaleModel->getTotalSalesByProduct($data['product_id'], $data['month'], $data['year']);
        $totalProductSales = $totalSales->total_product_sales ?? 0;

        $date = date("{$year}-${month}-1");
        $previousMonth = (int) date('m', strtotime('-1 months', strtotime($date)));
        $previousYear = (int) date('Y', strtotime('-1 months', strtotime($date)));

        $previousInventory = $this->inventoryModel->findInventory($data['product_id'], $previousMonth, $previousYear);
        $currentInventory = $this->inventoryModel->findInventory($data['product_id'], $month, $year);

        $numberOfPreviousInventory = data_get($previousInventory, 'number_of_remaining_goods', 0);
        $this->inventoryModel->syncRemainingGoods($data['product_id'], $month, $year, $totalProductSales, $currentInventory->number_of_imported_goods, $numberOfPreviousInventory);
    }

    public function syncYear($data)
    {
        $month = $data['month'];
        $year = $data['year'];

        for ($i = 0; $i < 12; $i++) {
            $month = $i + 1;
            $date = date("{$year}-${month}-1");

            $previousMonth = (int) date('m', strtotime('-1 months', strtotime($date)));
            $previousYear = (int) date('Y', strtotime('-1 months', strtotime($date)));
            $inventory = $this->inventoryModel->findInventory($data['product_id'], $month, $data['year']);

            if (!$inventory) {
                $newData = $data;
                $newData['month'] = $month;
                $newData['number_of_imported_goods'] = null;

                $this->inventoryModel->createInventory($newData);
                $inventory = $this->inventoryModel->findInventory($data['product_id'], $month, $data['year']);
            }

            $totalSales = $this->employeeSaleModel->getTotalSalesByProduct($data['product_id'], $month, $data['year']);
            $totalProductSales = $totalSales->total_product_sales ?? 0;

            $previousInventory = $this->inventoryModel->findInventory($data['product_id'], $previousMonth, $previousYear);
            $currentInventory = $this->inventoryModel->findInventory($data['product_id'], $month, $year);

            $numberOfPreviousInventory = data_get($previousInventory, 'number_of_remaining_goods', 0);
            $this->inventoryModel->syncRemainingGoods($data['product_id'], $month, $year, $totalProductSales, $currentInventory->number_of_imported_goods, $numberOfPreviousInventory);
        }
    }
}
