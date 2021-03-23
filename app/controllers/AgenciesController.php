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

    public function search()
    {
        $keyword = strval($_POST['query'] ?? '');
        $productResult = [];

        $search_param = "%{$keyword}%";

        $agencies = $this->agencyModel->searchAgencyByAMS($_SESSION['user_id'], $search_param);

        $agenciesOptions = array_map(function ($item) {
            return [
                'id' => $item->id,
                'text' => $item->name . ' - ' . $item->province
            ];
        }, $agencies);

        echo json_encode($agenciesOptions);
    }
}
