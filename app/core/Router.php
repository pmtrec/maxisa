<?php


namespace PMT\APP\CORE;
// require_once dirname(__DIR__, 2) . '/SRC/ENTITY/UserController.php';


class Router {
    private static array $routes;

    public static function chargeRoute() {
        self::$routes = require dirname(__DIR__, 2) . '/route/route.web.php';
    }

    public static function resolve() {
        self::chargeRoute();

        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($uri, PHP_URL_PATH);

        $routes = self::$routes[$method] ?? [];

        if (isset($routes[$path])) {
            $route = $routes[$path];
            $controllerName = $route[0] ?? null;
            $methodName = $route[1] ?? null;
            $middlewares = $route['middlewares'] ?? [];

            // Middleware logique
            if (!empty($middlewares)) {
                foreach ($middlewares as $middleware) {
                    if (is_callable($middleware)) {
                        $middleware();
                    } else {
                        echo "❌ Middleware non exécutable.";
                        return;
                    }
                }
            }

            if (class_exists($controllerName) && method_exists($controllerName, $methodName)) {
                

                $controller = new $controllerName();
                
                return call_user_func([$controller, $methodName]);
            } else {
                http_response_code(500);
                echo "❌ Méthode ou contrôleur invalide.";
            }
        } else {
            http_response_code(404);
            echo "❌ Page introuvable.";
        }
    }
}
