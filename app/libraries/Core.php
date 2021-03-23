<?php
/*
   * App Core Class
   * Creates URL & loads core controller
   * URL FORMAT - /controller/method/params
   */
class Core
{
  protected $currentController = 'PagesController';
  protected $currentMethod = 'index';
  protected $params = [];

  public function __construct()
  {
    $url = $this->getUrl();
    $params = $this->getParams();

    $controllerName = preg_replace("/-+/", " ", $this->data_get($url, '0'));
    $controllerName = ucwords($controllerName);
    $controllerName = preg_replace('/\s+/', '', $controllerName);
    $controllerName = $controllerName . "Controller";

    // Look in BLL for first value
    if (file_exists('app/controllers/' . $controllerName . '.php')) {
      // If exists, set as controller
      $this->currentController = $controllerName;
      // Unset 0 Index
      unset($url[0]);
    }

    // Require the controller
    require_once 'app/controllers/' . $this->currentController . '.php';

    // Instantiate controller class
    $this->currentController = new $this->currentController;

    // Check for second part of url
    if (isset($url[1])) {
      // Check to see if method exists in controller
      if (method_exists($this->currentController, $url[1])) {
        $this->currentMethod = $url[1];
        // Unset 1 index
        unset($url[1]);
      }
    }

    // Get params
    $this->params = !empty($params) ? ['params' => $params] : [];
    // Call a callback with array of params
    call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
  }

  public function data_get($data, $path)
  {
    return array_reduce(explode('.', $path), function ($o, $p) {
      return $o->$p ?? $o[$p] ?? false;
    }, $data);
  }

  public function getUrl()
  {
    if (isset($_SERVER['REQUEST_URI'])) {
      $url = rtrim($_SERVER['REQUEST_URI'], '/');
      $url = parse_url($url, PHP_URL_PATH);

      $url = filter_var($url, FILTER_SANITIZE_URL);
      $url = explode('/', $url);

      $url = array_values(array_filter($url, function ($var) {
        return ($var !== NULL && $var !== FALSE && $var !== "");
      }));

      return $url;
    }
  }

  public function getParams()
  {
    if (isset($_SERVER['REQUEST_URI'])) {
      $url = rtrim($_SERVER['REQUEST_URI'], '/');
      $query = parse_url($url, PHP_URL_QUERY);

      if (!is_null($query)) {
        parse_str($query, $queryArr);
        return $queryArr;
      } else {
        return [];
      }
    }
  }
}
