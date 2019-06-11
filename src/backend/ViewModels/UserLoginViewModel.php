<?php


namespace Messenger\ViewModels;


use Messenger\Core\BaseViewModel;

class UserLoginViewModel extends BaseViewModel
{
    public $Email, $Password;

    public function validate() :bool
    {
        if (!filter_var($this->Email, FILTER_VALIDATE_EMAIL))
            return false;
        if (strlen($this->Password) < 8)
            return false;
        return true;
    }
}