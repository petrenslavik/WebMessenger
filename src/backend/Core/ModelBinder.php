<?php


namespace Messenger\Core;


use ReflectionParameter;

class ModelBinder
{
    public static function BindModel(ReflectionParameter ...$args)
    {
        $argList = array();
        foreach ($args as $arg) {
            $argType = $arg->getType();
            if ($argType->isBuiltin())
            {
               $argList[] = $_REQUEST[$arg->getName()];
            }
            else
            {
                $class = $arg->getClass();
                $instance = $class->newInstance();
                $classArgs = $class->getProperties();
                foreach ($classArgs as $classArg)
                {
                    $name = $classArg->getName();
                    $instance->$name = $_REQUEST[$name];
                }
                $argList[] = $instance;
            }
        }
        return $argList;
    }
}