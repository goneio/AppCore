<?php
namespace Gone\AppCore\Router;

use Slim\App;

class Router
{
    protected static $instance;

    /** @var Route[] */
    protected $routes = [];

    public function __construct()
    {
    }

    /**
     * @return Router
     */
    public static function Instance()
    {
        if (! self::$instance instanceof Router) {
            self::$instance = new Router;
        }
        return self::$instance;
    }

    public function weighRoutes() : Router
    {
        $allocatedRoutes = [];
        if (is_array($this->routes) && count($this->routes) > 0) {
            uasort($this->routes, function (Route $a, Route $b) {
                return $a->getWeight() > $b->getWeight();
            });

            foreach ($this->routes as $index => $route) {
                if (!isset($allocatedRoutes[$route->getHttpMethod() . $route->getRouterPattern()])) {
                    $allocatedRoutes[$route->getHttpMethod() . $route->getRouterPattern()] = true;
                } else {
                    unset($this->routes[$index]);
                }
            }
        }
        return $this;
    }

    public function populateRoutes(App $app) : self
    {
        $this->weighRoutes();
        if (count($this->routes) > 0) {
            foreach ($this->routes as $route) {
                $route->populateRoute($app);
            }
        }
        return $this;
    }

    public function addRoute(Route $route)
    {
        $this->routes[$route->getUniqueIdentifier()] = $route;
        return $this;
    }

    /**
     * @return Route[]
     */
    public function getRoutes()
    {
        ksort($this->routes);
        return $this->routes;
    }
}
