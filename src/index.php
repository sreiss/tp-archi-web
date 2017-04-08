<?php

define('BASEURL', dirname($_SERVER['SCRIPT_NAME']));
define('BASEPATH', dirname($_SERVER['SCRIPT_FILENAME']));
define('HOST', 'http://' . $_SERVER['HTTP_HOST']);

include_once BASEPATH . '/models/shopping-item.model.php';
require_once BASEPATH . '/utils/page-config.class.php';

if (!session_id()) {
    session_start();
}

include 'models/route.model.php';

$routes = [
    'shopping-cart'    => new \Route('shopping-cart', 'ShoppingCart', [
        'index' => 'GET /',
        'add_to_cart' => 'POST /',
        'remove_from_cart' => 'DELETE /(?<id>\d+)',
        'update_in_cart' => 'PUT /(?<id>\d+)'
    ]),
    'design'           => new \Route('design', 'Design', [
        'get_items' => 'GET /items',
        'index' => 'GET /'
    ]),
    '' => new \Route('home', 'Home', [
        'index' => 'GET /'
    ])
];

$params = [];
if (isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] != '/') {
    $path = $_SERVER['PATH_INFO'];

    // We check if the current path corresponds to a route
    foreach ($routes as $r_name => $route) {
        if ($r_name === '') {
            $stripped_path = substr($path, 1);
        } else {
            $stripped_path = substr($path, 1, strlen($r_name));
        }

        if ($stripped_path === $r_name) {
            $route_name = $r_name;
            break;
        }
    }

    // If a route was found, we determine the method name, from the http method.
    if (isset($route_name) && isset($routes[$route_name]) && $methods = $routes[$route_name]->get_methods()) {
        foreach ($methods as $m_name => $m_verb_path) {
            $verb_path = explode(' ', $m_verb_path);

            if ($_SERVER['REQUEST_METHOD'] != $verb_path[0]) {
                continue;
            }

            if (substr($verb_path[1], -1) == '/') {
                $verb_path[1] = substr($verb_path[1], 0, -1);
            }

            $full_m_path = addcslashes('/' . $route_name . $verb_path[1], '/');
            $vars = [];
            if ($ps = preg_match('/' . $full_m_path . '/', $path, $vars)) {
                $method_name = $m_name;
                foreach ($vars as $index => $value) {
                    if (is_string($index)) {
                        $params[] = $value;
                    }
                }
                break;
            } else {
                continue;
            }
        }
    }

    // If the method is a get, we build an associative array with the query
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $query = [];

        if (isset($_SERVER['QUERY_STRING'])) {
            $query_parts = explode('&', $_SERVER['QUERY_STRING']);
            foreach ($query_parts as $q_item) {
                $q_item_parts = explode('=', $q_item);
                if (count($q_item_parts) == 2) {
                    $query[$q_item_parts[0]] = $q_item_parts[1];
                }
            }
        }

        array_unshift($params, $query);
    }
} else {
    // Default page: home
    $route_name = '';
    $method_name = 'index';
}

$error_code = 404;
$error_message = null;
if (isset($route_name) && isset($method_name) && isset($routes[$route_name]) && isset($routes[$route_name]->get_methods()[$method_name])) {
    PageConfig::get_instance()->set_script_file($route_name);
    $route = $routes[$route_name];
    require_once 'controllers/' . $route->get_file() . '.controller.php';

    $method = $method_name;
    $controller_name = $route->get_controller() . 'Controller';
    $controller = new $controller_name;
    try {
        call_user_func_array([$controller, $method], $params);
    } catch (Error $e) {
        $error_message = $e->getMessage();
        $error_code = $e->getCode();
    }
} else {
    $error_message = 'Not found';
}

// If no route or method was found, we throw an error
if (!is_null($error_message)) {
    require_once 'controllers/error.controller.php';

    http_response_code($error_code);

    $controller = new ErrorController();
    $controller->index($error_message);
}

?>