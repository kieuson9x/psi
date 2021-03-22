<?php
class InventoriesController extends Controller
{
    private $db;
    public function __construct()
    {
        $this->inventoryModel = $this->model('Inventory');
        $this->initEmployeeLevelOptions();
        $this->initBusinessUnitOptions();
        $this->initIndustryOptions();
        $this->initProductTypeOptions();
    }

    public function index()
    {
        $data = [];
        $year = (int) ($_GET['year'] ?? date('Y'));
        $data['year'] = $year;

        if ($_SESSION['user_id']) {
            $year = $data['year'] ?? date('Y');

            $inventories = $this->inventoryModel->getInventories($year);

            $data['inventories'] = $inventories;
        }


        $this->view('inventories/index', $data);
    }

    public function update()
    {

        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'month' => (int) $this->data_get($_POST, 'name'),
                'value' => (int) trim($this->data_get($_POST, 'value')),
                'product_id' => (int) trim($this->data_get($_POST, 'pk')),
                'year' => (int) trim($this->data_get($_POST, 'year')),
                'state' => trim($this->data_get($_POST, 'state')),
            ];

            if ($data['state'] === 'purchase') {
                $data['number_of_imported_goods'] = $data['value'];
            }

            // if ($data['state'] === 'inventory') {
            //     $data['number_of_remaining_goods'] = $data['value'];
            // }

            $inventory = $this->inventoryModel->findInventory($data['product_id'], $data['month'], $data['year']);

            if ($inventory) {
                $updateStatus = $this->inventoryModel->updateInventory($inventory->id, $data);
            } else {
                $createStatus = $this->inventoryModel->createInventory($data);
            }

            echo json_encode(['success' => true]);

            // if ($this->inventoryModel->updateOrCreateInventory($data)) {
            //     echo json_encode(['success' => true]);
            // } else {
            //     die("Something went wrong, please try again!");
            // }
        }
    }

    public function create()
    {
        $data = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'months' => $this->data_get($_POST, 'months'),
                'product_id' => (int) $this->data_get($_POST, 'product_id'),
                'year' => (int) $this->data_get($_POST, 'year'),
                'number_of_imported_goods' => $this->data_get($_POST, 'number_of_imported_goods'),
                // 'number_of_remaining_goods' => $this->data_get($_POST, 'number_of_remaining_goods'),
            ];
            $updateStatus = true;
            $createStatus = true;
            foreach ($data['months'] as $month) {
                $inventory = $this->inventoryModel->findInventory($data['product_id'], $month, $data['year']);

                if ($inventory) {
                    $updateStatus = $this->inventoryModel->updateInventory($inventory->id, $data);
                } else {
                    $data['month'] = $month;
                    $createStatus = $this->inventoryModel->createInventory($data);
                }
            }

            if ($updateStatus || $createStatus) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
            // if ($this->inventoryModel->updateOrCreateInventory($data)) {
            //     echo json_encode(['success' => true]);
            // } else {
            //     die("Something went wrong, please try again!");
            // }
        }
    }
}
