<?php

require_once 'Model/Model.php';
require_once 'View/View.php';
require_once 'Controller/ProjectController.php';



$requestUri = $_SERVER['REQUEST_URI'];


// Routes
$routes = [
    '/' => 'ProjectController@indexAction',
    '/project/(\d+)' => 'ProjectController@detailAction',
    '/kontakt' =>'ProjectController@kontaktAction'
];

// Suche nach passender Route
$matchedRoute = null;
foreach ($routes as $routePattern => $controllerAction) {
    $pattern = '~^' . $routePattern . '$~';
    if (preg_match($pattern, $requestUri, $matches)) {
        $matchedRoute = $controllerAction;
        break;
    }
}

// Wenn keine passende Route gefunden wurde, zeige eine 404-Seite an
if (!$matchedRoute) {
    header('HTTP/1.0 404 Not Found');
    echo '404 Not Found';
    exit;
}

// Aufteilen des Controller-Action-Strings
list($controllerName, $actionName) = explode('@', $matchedRoute);

// Instanz des Controllers erstellen
$controller = new $controllerName();

// Die Action-Methode aufrufen
if (isset($matches[1])) {
    $controller->$actionName($matches[1]);
} else {
    $controller->$actionName();
}

?>