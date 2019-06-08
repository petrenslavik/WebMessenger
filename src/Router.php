<?php

namespace Messenger;

use Exception;
use Messenger\Core\ModelBinder;
use ReflectionMethod;

class Router
{
    private function ParseURL($url)
    {
        $URLComponents = explode('/', $url);
        array_shift($URLComponents);
        $controllerName = ucfirst(array_shift($URLComponents));
        $actionName = ucfirst(array_shift($URLComponents));
        if (empty(trim($actionName)))
            $actionName = 'Index';
        return array('controller' => $controllerName,
            'action' => $actionName,
            'params' => $URLComponents);
    }

    public function Run()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {
            $exist = is_file("../dist/js/app.7517b2db.js/");
            echo $exist;
            ob_start();
            include("../dist/index.html");
            $content = ob_get_contents();
            ob_end_clean();
            echo $content;
            return;
        }

        $route = $this->ParseURL($_SERVER["REQUEST_URI"]);
        $className = 'Messenger\Controllers\\' . $route['controller'] . 'Controller';
        $methodName = $route['action'];
        if (class_exists($className)) {
            $controller = new $className();
            if (method_exists($controller, $methodName)) {
                $reflection = new ReflectionMethod($controller, $methodName);
                $arguments = $reflection->getParameters();
                $params = ModelBinder::BindModel(...$arguments);
                return $controller->$methodName(...$params);
            } else
                throw new Exception('Error 404');
        } else {
            throw new Exception('Error 404');
        }
    }
}