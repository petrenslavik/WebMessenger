<?php
    namespace Messenger;
    use Messenger\Application\Router;

    spl_autoload_register(function ($class_name) {
        $parts = explode('\\',$class_name);
        array_splice($parts, 0, 1);
        $filePath = implode("\\", $parts).'.php';
        if (is_file($filePath))
            include($filePath);
    });
    $router = new Router();
    $router->Run();
