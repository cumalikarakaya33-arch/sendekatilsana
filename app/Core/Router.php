<?php
class Router {
  private array $routes = ['GET'=>[], 'POST'=>[]];

  public function get(string $path, $handler): void  { $this->routes['GET'][$path]  = $handler; }
  public function post(string $path, $handler): void { $this->routes['POST'][$path] = $handler; }

  public function dispatch(string $method, string $path): void {
    $handler = $this->routes[$method][$path] ?? null;
    if (!$handler) { http_response_code(404); echo '404 Not Found'; return; }

    if (is_callable($handler)) { call_user_func($handler); return; }
    if (is_array($handler) && count($handler)===2) {
      [$class, $func] = $handler;
      if (is_string($class) && class_exists($class)) { $class = new $class(); }
      call_user_func([$class, $func]); return;
    }
    echo 'Invalid route handler';
  }
}
