<?php

namespace App;

class Slim extends \Slim\Slim
{
    public function mapRoute($args)
    {
        $callable = array_pop($args);
        if (is_string($callable) && strpos($callable, ':')) {
            $callable = $this->createControllerCallable($callable);
        }
        $args[] = $callable;

        return parent::mapRoute($args);
    }

    protected function createControllerCallable($name)
    {
        list($controllerName, $actionName) = explode(':', $name);

        // Create a callable that will find or create the controller instance
        // and then execute the action
        $app = $this;
        $callable = function () use ($app, $controllerName, $actionName) {

            // Try to fetch the controller instance from Slim's container
            if ($app->container->has($controllerName)) {
                $controller = $app->container->get($controllerName);
            } else {
                // not in container, assume it can be directly instantiated
                $controller = new $controllerName($app);
            }

            // Set the request and response if we can
            if (method_exists($controller, 'setRequest')) {
                $controller->setRequest($app->request);
            }
            if (method_exists($controller, 'setResponse')) {
                $controller->setResponse($app->response);
            }

            return call_user_func_array(array($controller, $actionName), func_get_args());
        };

        return $callable;
    }
}
