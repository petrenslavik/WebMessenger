<?php


namespace Messenger\ViewModels;


use Messenger\Core\BaseViewModel;

class UserRegisterViewModel extends BaseViewModel
{
    public $FirstName, $SecondName, $Email, $Password, $Username, $RepeatPassword;

    public function validate():bool
    {
        if (filter_var($this->Email, FILTER_VALIDATE_EMAIL))
            return false;
        if (ctype_alnum($this->Username))
            return false;
        if (strlen($this->Password) < 8)
            return false;
        if($this->Password == $this->RepeatPassword)
            return false;
        return true;
    }
}