<?php

namespace Proton\Http;

use Proton\Http\Response;
use Proton\Http\Request;
use Proton\View\View;

class Route
{
    protected Request $request;
    protected Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    protected static array $routes = [];

    /**
     *  @param  Register GET.
     */
    public static function get(string $path, $action): void
    {
        self::$routes['get'][$path] = $action;
    }

    /**
     *@param  Register POST.
     */
    public static function post(string $path, $action): void
    {
        self::$routes['post'][$path] = $action;
    }

    /**
     * @param Register PUT.
     */
    public static function put(string $path, $action): void
    {
        self::$routes['put'][$path] = $action;
    }

    /**
     *@param Register DELETE.
     */
    public static function delete(string $path, $action): void
    {
        self::$routes['delete'][$path] = $action;
    }

    /**
     * @param Select action Method .
     */
    public function resolve()
    {
        $path = $this->request->path();
        $method = $this->request->method();
        if (array_key_exists($method, self::$routes) && array_key_exists($path, self::$routes[$method])) {
            $action = self::$routes[$method][$path];
            
            if (is_string($action)) {
                return $this->callActionString($action);
            }

            if (is_callable($action)) {
                return $this->callActionCallable($action);
            }

            if (is_array($action)) {
                return $this->callActionArray($action);
            }
        } else {
            $this->response->setStatusCode(404);
            View::makeError('_404');
            return $this->response;
        }
    }
    
    private function callActionString(string $action)
    {
        return call_user_func_array($action, []);
    }

    /**
    * Call the action when it is callable.
    */
    private function callActionCallable($action)
    {
        return call_user_func_array($action, []);
    }

   /**
   * Call the action when it is an array containing a class and a method.
   */
    private function callActionArray(array $action)
    { 
        if (class_exists($action[0]) && method_exists($action[0], $action[1])) {
            return call_user_func_array([new $action[0], $action[1]], []);
        }
        
        $this->response->setStatusCode(500);
        return $this->response->json(['error' => 'Action not found.'], 500);
    }
}
