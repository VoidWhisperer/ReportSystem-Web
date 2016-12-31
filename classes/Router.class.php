<?php
include "config.php";
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/31/2016
 * Time: 2:56 PM
 */
class Router
{

    private $routes = array();

    /**
     * Router constructor.
     */
    public function __construct()
    {

    }

    /**
     * Insert a new route into the router
     * @param $route The route that the request would have, minus any right-side slash
     * @param $class The class to load  to represent this route
     */
    public function insertRoute($route,$class) {
        $routes[$route] = $class;
    }

    /**
     * Match the request to a route if any exist
     * @return bool return true if the route exists and is loaded, return false otherwise.
     */
    public function match() {
        $data = null;
        if(isset($_SERVER['REQUEST_METHOD'])) {
            if(strcmp($_SERVER['REQUEST_METHOD'],"GET")) {
                $data = $_GET;
            }else if(strcmp($_SERVER['REQUEST_METHOD'],"POST")) {
                $data = $_POST;
            }else{
                return false;
            }

            $requestUri = chop($_SERVER['REQUEST_URI'],"/");
            foreach ($this->routes as $route => $class) {
                if(strcmp($requestUri,$route)) {
                    include 'routes/'.$class;
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Remove a route
     * @param $route The route to remove
     * @return bool true if the route was removed, false if it didn't exist.
     */
    public function removeRoute($route) {
        if(isset($this->routes[$route])) {
            unset($this->routes[$route]);
            return true;
        }
        return false;
    }
}