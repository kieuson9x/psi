<?php
class EmployeesController extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('Employee');
        $this->initEmployeeLevelOptions();
    }

    public function index($params = [])
    {
        $employeeLevel = $this->data_get($params, 'level_id');

        if (!$employeeLevel) {
            $users = [];
        } else {
            $users = $this->userModel->showByLevel($employeeLevel);
        }

        $data = [
            'users' => $users,
            'employeeLevel' => $employeeLevel,
        ];

        $this->view('employees/index', $data);
    }

    public function register()
    {
        $data = [
            'user_name' => '',
            'email' => '',
            'password' => '',
            'confirmPassword' => '',
            'user_nameError' => '',
            'emailError' => '',
            'passwordError' => '',
            'confirmPasswordError' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'user_name' => trim($_POST['user_name']),
                'full_name' => trim($_POST['full_name']),
                // 'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirmPassword' => trim($_POST['confirmPassword']),
                'user_nameError' => '',
                'emailError' => '',
                'passwordError' => '',
                'confirmPasswordError' => ''
            ];

            $nameValidation = "/^[a-zA-Z0-9]*$/";
            $passwordValidation = "/^(.{0,7}|[^a-z]*|[^\d]*)$/i";

            //Validate user_name on letters/numbers
            if (empty($data['user_name'])) {
                $data['user_nameError'] = 'Please enter user_name.';
            } elseif (!preg_match($nameValidation, $data['user_name'])) {
                $data['user_nameError'] = 'Name can only contain letters and numbers.';
            }

            // //Validate email
            // if (empty($data['email'])) {
            //     $data['emailError'] = 'Please enter email address.';
            // } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            //     $data['emailError'] = 'Please enter the correct format.';
            // } else {
            //     //Check if email exists.
            //     if ($this->userModel->findUserByEmail($data['email'])) {
            //         $data['emailError'] = 'Email is already taken.';
            //     }
            // }

            // Validate password on length, numeric values,
            if (empty($data['password'])) {
                $data['passwordError'] = 'Please enter password.';
            }
            // } elseif (strlen($data['password']) < 6) {
            //     $data['passwordError'] = 'Password must be at least 8 characters';
            // } elseif (preg_match($passwordValidation, $data['password'])) {
            //     $data['passwordError'] = 'Password must be have at least one numeric value.';
            // }

            //Validate confirm password
            if (empty($data['confirmPassword'])) {
                $data['confirmPasswordError'] = 'Please enter password.';
            } else {
                if ($data['password'] != $data['confirmPassword']) {
                    $data['confirmPasswordError'] = 'Passwords do not match, please try again.';
                }
            }

            // Make sure that errors are empty
            if (empty($data['user_nameError']) && empty($data['emailError']) && empty($data['passwordError']) && empty($data['confirmPasswordError'])) {
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                //Register user from model function
                if ($this->userModel->register($data)) {
                    //Redirect to the login page
                    header('location: ' . URLROOT . '/employees/login');
                } else {
                    die('Something went wrong.');
                }
            }
        }
        $this->view('employees/register', $data);
    }

    public function login()
    {
        $data = [
            'title' => 'Login page',
            'user_name' => '',
            'password' => '',
            'user_nameError' => '',
            'passwordError' => ''
        ];

        //Check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'user_name' => trim($_POST['user_name']),
                'password' => trim($_POST['password']),
                'user_nameError' => '',
                'passwordError' => '',
            ];
            //Validate user_name
            if (empty($data['user_name'])) {
                $data['user_nameError'] = 'Hãy nhập tên đăng nhập!';
            }

            //Validate password
            if (empty($data['password'])) {
                $data['passwordError'] = 'Hãy nhập mật khẩu!';
            }

            //Check if all errors are empty
            if (empty($data['user_nameError']) && empty($data['passwordError'])) {
                $loggedInUser = $this->userModel->login($data['user_name'], $data['password']);

                if ($loggedInUser) {
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['passwordError'] = 'Tên đăng nhập hoặc mật khẩu không đúng!. Hãy thử lại.';

                    $this->view('employees/login', $data);
                }
            }
        } else {
            $data = [
                'user_name' => '',
                'password' => '',
                'user_nameError' => '',
                'passwordError' => ''
            ];
        }
        $this->view('employees/login', $data);
    }

    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->user_name;
        $_SESSION['full_name'] = $user->full_name;
        $_SESSION['level_id'] = $user->level_id;
        header('location:' . URLROOT . '/pages/index');
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['full_name']);
        unset($_SESSION['level_id']);
        unset($_SESSION['employeeLevelOptions']);
        var_dump($_SESSION);
        header('location:' . URLROOT . '/employees/login');
    }
}
