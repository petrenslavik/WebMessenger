<?php


namespace Messenger\Controllers;
use Messenger\Core;
use Messenger\Database\Interfaces\IEmailTokenRepository;
use Messenger\Database\Repositories\UserRepository;
use Messenger\Database\Repositories\EmailTokenRepository;
use Messenger\Models\EmailToken;
use Messenger\Models\User;
use Messenger\ViewModels\UserRegisterViewModel;
use Messenger\Database\Interfaces\IUserRepository;

class UserController extends Core\BaseController
{
    /** @var IUserRepository $object */
    protected $userRepository;

    /** @var IEmailTokenRepository $object */
    protected $emailTokenRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->emailTokenRepository = new EmailTokenRepository();
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
        $request = array();
        $request['code'] = 0;
        if(!($model->validate())) {
            $request[] = "Data not Valid";
        }
        $user = $this->userRepository->GetUserByEmail($model->Email);
                if($user) {
            $request[] = "Email is already taken.";
        }
        $user = $this->userRepository->GetUserByUsername($model->Username);
        if($user) {
            $request[] = "User with this username already registered";
        }
        if(count($request) > 1)
        {
            echo json_encode($request);
            return;
        }
        $newUser = new User();
        $newUser->FirstName = $model->FirstName;
        $newUser->SecondName = $model->SecondName;
        $newUser->Email = $model->Email;
        $newUser->PasswordHash = password_hash($model->Password,PASSWORD_DEFAULT);
        $newUser->Username= $model->Username;
        $this->userRepository->Insert($newUser);
        $request['code'] = 1;
        $request[] = "Register successful";
        echo json_encode($request);

        $token = new EmailToken();
        $token->User = $newUser->Id;
        $token->Token = hash("sha256",$newUser->Email."saltySalt");
        $this->emailTokenRepository->Insert($token);
        $subject = 'Email Confirmation';
        $message = "Confirmation url: <a href = \"{$_SERVER['HTTP_HOST']}/user/confirmEmail/?token={$token->Token} \">Confirm</a>";
        $headers = 'From: noreply@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion() . "\r\nContent-Type: text/html; charset=ISO-8859-1\r\n";

        mail($newUser->Email, $subject, $message, $headers);
    }

    public function ConfirmEmail(string $token)
    {
        $emailToken = $this->emailTokenRepository->GetByToken($token);
        $user = $this->userRepository->GetById($emailToken->User);
        $user->Verified = true;
        $this->userRepository->Update($user);
        $this->emailTokenRepository->Delete($emailToken->Id);
        echo json_encode("Email verified");
    }
}