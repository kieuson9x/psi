<?php
//Load the model and the view
class Controller
{
    public function initEmployeeLevelOptions()
    {
        if ($_SESSION['user_id'] && !isset($_SESSION['employeeLevelOptions'])) {
            require_once 'app/models/EmployeeLevel.php';

            $employeeLevel = new EmployeeLevel();

            $employeeLevelOptions = $employeeLevel->getLevelOptions();

            $_SESSION['employeeLevelOptions'] = $employeeLevelOptions;
        }
    }

    public function model($model)
    {
        //Require model file
        require_once 'app/models/' . $model . '.php';
        //Instantiate model
        return new $model();
    }

    //Load the view (checks for the file)
    public function view($view, $data = [])
    {
        if (file_exists('app/views/' . $view . '.php')) {
            require_once 'app/views/' . $view . '.php';
        } else {
            die("View does not exists.");
        }
    }

    function data_get($data, $path)
    {
        return array_reduce(explode('.', $path), function ($o, $p) {
            return $o->$p ?? $o[$p] ?? false;
        }, $data);
    }
}
