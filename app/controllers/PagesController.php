<?php
class PagesController extends Controller
{
    public function __construct()
    {
        //$this->userModel = $this->model('User');
        $this->initEmployeeLevelOptions();
    }

    public function index()
    {
        $employeeLevelOptions = $this->model('EmployeeLevel')->getLevelOptions();
        $data = [
            'title' => 'Home page',
            'employeeLevelOptions' => $employeeLevelOptions
        ];

        $this->view('index', $data);
    }

    public function about()
    {
        $this->view('about');
    }
}
