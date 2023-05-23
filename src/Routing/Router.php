<?php

namespace App\Routing;

use Exception;

class Router
{
    private $routes = [];

    private function access($accessArray)
    {
        if (count($accessArray)) {
            $type = $accessArray[0];
            $guard = $accessArray[1];
            if (!in_array($type, ["guest", "auth"])) {
                throw new Exception("Access array's first value must be either 'guest' or 'auth'.");
            }
            if (!in_array($guard, ["user", "admin"])) {
                throw new Exception("Access array's second value must be a known guard.");
            }
            if ($type === "guest") {
                if (isset($_SESSION[$guard])) {
                    redirect("/dashboard");
                }
            }
            if ($type === "auth") {
                if (!isset($_SESSION[$guard])) {
                    redirect("/login");
                }
            }
        }
    }
    public function route()
    {
        $path = explode("?", $_SERVER["REQUEST_URI"])[0];
        $available_uris = array_column($this->routes, "uri");
        if (!in_array($path, $available_uris)) {
            http_response_code(404);
            die;
        }
        foreach ($this->routes as $route) {
            if ($route["uri"] === $path && $route["method"] === $_SERVER["REQUEST_METHOD"]) {
                $this->access($route["access"]);
                $action = $route["action"];
                return $action();
            }
        }
        http_response_code(405);
        die;
    }
    public function get(String $path, callable $action, array $access = [])
    {
        $this->routes[] = [
            "uri" => $path,
            "action" => $action,
            "method" => "GET",
            "access" => $access
        ];
    }
    public function post(String $path, callable $action, array $access = [])
    {
        $this->routes[] = [
            "uri" => $path,
            "action" => $action,
            "method" => "POST",
            "access" => $access
        ];
    }
    public function delete(String $path, callable $action, array $access = [])
    {
        $this->routes[] = [
            "uri" => $path,
            "action" => $action,
            "method" => "DELETE",
            "access" => $access
        ];
    }
    public function update(String $path, callable $action, array $access = [])
    {
        $this->routes[] = [
            "uri" => $path,
            "action" => $action,
            "method" => "UPDATE",
            "access" => $access
        ];
    }
}
