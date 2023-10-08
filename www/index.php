<?php

ini_set('display_errors', 1);

require_once "config.php";
require_once WWW_DIR . "../vendor/autoload.php";
require_once WWW_DIR . "lib/user.php";
require_once WWW_DIR . "lib/page.php";


$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', 'IndexController@index');
    // Browser
    $r->addRoute('GET', '/browser', 'BrowserController@index');
    $r->addRoute('GET', '/browser/{path:.*}', 'BrowserController@index');
    $r->addRoute('GET', '/download/{path:.*}', 'BrowserController@download');
    $r->addRoute('GET', '/upload/{path:.*}', 'BrowserController@upload');
    // Browser -> Actions
    $r->addRoute('POST', '/actions-browser', 'ActionBrowserController@handleRequest');
    // Viewer
    $r->addRoute('GET', '/viewer', 'ViewerController@drop');
    $r->addRoute('GET', '/viewer/{path:.*}', 'ViewerController@view');
    // Standardanmeldung
    $r->addRoute('GET', '/login', 'AuthController@login');
    $r->addRoute('POST', '/login', 'AuthController@login');  // POST-Handling für das Einreichen des Anmeldeformulars
    // OIDC-Anmeldung
    $r->addRoute('GET', '/oidc-login', 'AuthController@oidcLogin');
    // Abmeldung
    $r->addRoute('GET', '/logout', 'AuthController@logout');
    // Standardregistrierung
    $r->addRoute('GET', '/register', 'AuthController@register');
    $r->addRoute('POST', '/register', 'AuthController@register');  // POST-Handling für das Einreichen des Registrierungsformulars
    // Profil
    $r->addRoute('GET', '/profile', 'ProfileController@index');
});

$URL_PATH = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$URL_PATH = str_replace(WWW_TOP, '', $URL_PATH);

$routeInfo = $dispatcher->dispatch(
    $_SERVER['REQUEST_METHOD'], // z.B. GET, POST, usw.
    $URL_PATH // der Pfad der Anfrage
);

$user = new UserClass();

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // Keine Route entsprach dem angeforderten URl
        http_response_code(404);
        require VIEWS_DIR.'/error/404.html'; // oder irgendeine andere Fehlerbehandlung
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        // Es gibt eine Route, die dem URl entspricht, aber nicht der Methode
        http_response_code(405);
        require VIEWS_DIR.'/error/405.html'; // oder irgendeine andere Fehlerbehandlung
        break;
    case FastRoute\Dispatcher::FOUND:
        list($controller, $method) = explode('@', $routeInfo[1]);
        $params = $routeInfo[2];
        $controller = 'Site\\Controllers\\'.$controller;
        (new $controller($user))->{$method}(...$params);
        break;
    default:
        http_response_code(404);
        require VIEWS_DIR.'/error/unknown.html'; // oder irgendeine andere Fehlerbehandlung
        break;
}
