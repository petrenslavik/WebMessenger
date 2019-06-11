<?php


namespace Messenger\Core;


abstract class BaseViewModel
{
    abstract protected function validate():bool;
}