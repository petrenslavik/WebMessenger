<?php


namespace Messenger\Controllers;
use Messenger\Core;
use Messenger\Database\BaseRepository;
use Messenger\Database\Database;
use Messenger\ViewModels\TestModel;
use Messenger\ViewModels\UserViewModel;

class UserController extends Core\BaseController
{
    public function Index(TestModel $model, int $someval, string $SecondName)
    {
        echo $model->Id;
        echo $model->Name;
        print_r($someval);
        print_r($SecondName);
    }
    public function Insert(UserViewModel $model)
    {
        $rep = new BaseRepository("Users","Messenger\Models\User");
        $model->PasswordHash = password_hash($model->PasswordHash,PASSWORD_DEFAULT);
        $rep->Insert($model);
    }
    public function SignIn(UserViewModel $model)
    {
        $rep = new BaseRepository("Users","Messenger\Models\User");
        $user = $rep->GetById(4);
        if (password_verify($model->PasswordHash,$user->PasswordHash))
        {
            echo "Successfully login";

        }
        else
        {
            echo "Wrong password";
        }
    }
    public function Test()
    {

    }
}