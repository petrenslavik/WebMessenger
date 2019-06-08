<?php


namespace Messenger\Controllers;
use Messenger\Core;
use Messenger\Database\Repositories\UserRepository;
use Messenger\Models\User;
use Messenger\ViewModels\UserRegisterViewModel;

class UserController extends Core\BaseController
{
    /** @var UserRepository $object */
    protected $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

  /*  public function Insert(UserViewModel $model)
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
*/
    public function Register(UserRegisterViewModel $model)
    {
        if($model->validate()) {
            echo "Data not Valid";
            return;
        }
        $user = $this->userRepository->GetUserByEmail($model->Email);
        if($user) {
            echo "User with this email already registered";
            return;
        }
        $user = $this->userRepository->GetUserByUsername($model->Email);
        if($user) {
            echo "User with this username already registered";
            return;
        }
        $newUser = new User();
        $newUser->FirstName = $model->FirstName;
        $newUser->SecondName = $model->SecondName;
        $newUser->Email = $model->Email;
        $newUser->PasswordHash = password_hash($model->Password,PASSWORD_DEFAULT);
        $newUser->Username= $model->Username;
        $this->userRepository->Insert($newUser);
        echo "Register successful";
    }
}