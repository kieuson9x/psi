<?php
class InventoriesController extends Controller
{
    private $db;
    public function __construct()
    {
        $this->inventoryModel = $this->model('Inventory');
        $this->initEmployeeLevelOptions();
    }

    public function index()
    {
        $data = [];

        if ($_SESSION['user_id']) {
            $inventories = $this->inventoryModel->getInventories();

            $data = [
                'inventories' => $inventories,
            ];
        }


        $this->view('inventories/index', $data);
    }
}
