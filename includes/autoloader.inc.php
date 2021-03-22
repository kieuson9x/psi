<?php
spl_autoload_register('myAutoLoader');
spl_autoload_register('renderView');

function myAutoLoader($className)
{
    $path = "classes/";
    $extension = ".php";

    $fullPath = $path . $className . $extension;

    include_once $fullPath;
}

function renderView($viewPath, array $vars)
{
    $viewPath = str_replace('/', '\\', $viewPath);
    // == we convert the variables passed in vars
    // == to "real" native PHP variables
    if (count($vars) > 0) {
        foreach ($vars as $k => $v) {
            ${$k} = $v;
        }
    }
    // == we save a copy of the content already existing
    // == at the output buffer (for no interrump it)
    $existing_render = ob_get_clean();
    // == we begin a new output
    ob_start();
    include(dirname(__FILE__, 2) . '\\views' . $viewPath . '.view.php');
    // == we get the current output
    $render = ob_get_clean();
    // == we re-send to output buffer the existing content
    // == before to arrive to this function ;)
    ob_start();
    echo $existing_render;

    return $render;
}

// function data_get($data, $path, $default = null)
// {
//     return array_reduce(explode('.', $path), function ($o, $p) use ($default) {
//         if (isset($o->$p)) return (is_object($o->$p) ? (array) $o->$p : $o->$p) ?? $default;
//         if (isset($o[$p])) return (is_object($o[$p]) ? (array) $o[$p] : $o[$p])  ?? $default;

//         return $default;
//     }, $data);
// }
