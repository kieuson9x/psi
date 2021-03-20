<?php
class AgenciesController extends Controller
{
    private $db;
    public function __construct()
    {
        $this->agencyModel = $this->model('Agency');
        $this->initEmployeeLevelOptions();
    }

    public function index()
    {
        $data = [];

        if ($_SESSION['user_id']) {
            $agencies = $this->agencyModel->getAgenciesByAMS($_SESSION['user_id']);

            $data = [
                'agencies' => $agencies,
            ];
        }


        $this->view('agencies/index', $data);
    }
}
