<?php
//Database params
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'psi');

//APPROOT
define('APPROOT', dirname(dirname(__FILE__)));

//URLROOT (Dynamic links)
define('URLROOT', 'http://psi.test:8080');

//Sitename
define('SITENAME', 'PSI');

function data_get($data, $path, $default = null)
{
    return array_reduce(explode('.', $path), function ($o, $p) use ($default) {
        if (isset($o->$p)) return (is_object($o->$p) ? (array) $o->$p : $o->$p) ?? $default;
        if (isset($o[$p])) return (is_object($o[$p]) ? (array) $o[$p] : $o[$p])  ?? $default;

        return $default;
    }, $data);
}
