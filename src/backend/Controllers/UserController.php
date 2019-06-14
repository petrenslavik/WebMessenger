<?php


namespace Messenger\Controllers;

use Messenger\Core;
use Messenger\Database\Interfaces\IEmailTokenRepository;
use Messenger\Database\Repositories\UserRepository;
use Messenger\Database\Repositories\EmailTokenRepository;
use Messenger\Models\EmailToken;
use Messenger\Models\User;
use Messenger\ViewModels\UserLoginViewModel;
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

    public function Register(UserRegisterViewModel $model)
    {
        $response = array();
        $response['code'] = 0;
        if (!($model->validate())) {
            $response[] = "Data not Valid";
        }
        $user = $this->userRepository->GetUserByEmail($model->Email);
        if ($user) {
            $response[] = "Email is already taken.";
        }
        if($model->Username) {
            $user = $this->userRepository->GetUserByUsername($model->Username);
            if ($user) {
                $response[] = "User with this username already registered";
            }
        }
        if (count($response) > 1) {
            echo json_encode($response);
            return;
        }
        $newUser = new User();
        $newUser->FirstName = $model->FirstName;
        $newUser->SecondName = $model->SecondName;
        $newUser->Email = $model->Email;
        $newUser->PasswordHash = password_hash($model->Password, PASSWORD_DEFAULT);
        $newUser->Username = $model->Username;
        $newUser->Verified = false;
        $this->userRepository->Insert($newUser);
        $response['code'] = 1;
        $response[] = "Register successful";
        echo json_encode($response);

        $token = new EmailToken();
        $token->User = $newUser->Id;
        $token->Token = hash("sha256", $newUser->Email . "saltySalt");
        $this->emailTokenRepository->Insert($token);
        $subject = 'Email Confirmation';
        $message = "Confirmation url: <a href = \"{$_SERVER['HTTP_HOST']}/confirmEmail/?token={$token->Token} \">Confirm</a>";
        $headers = 'From: noreply@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion() . "\r\nContent-Type: text/html; charset=ISO-8859-1\r\n";

        mail($newUser->Email, $subject, $message, $headers);
    }

    public function ConfirmEmail(string $token)
    {
        $emailToken = $this->emailTokenRepository->GetByToken($token);
        if (!$emailToken) {
            echo json_encode("Token didn't exist");
            return;
        }
        $user = $this->userRepository->GetById($emailToken->User);
        $user->Verified = true;
        $this->userRepository->Update($user);
        $this->emailTokenRepository->Delete($emailToken->Id);
        echo json_encode("Email verified");
    }

    public function Login(UserLoginViewModel $model)
    {
        $response = array();
        $response['code'] = 0;
        if (!($model->validate())) {
            $response[] = "Data not valid.";
        }

        $user = $this->userRepository->GetUserByEmail($model->Email);
        if (!$user) {
            $response[] = "Wrong credentials.";
            echo json_encode($response);
            return;
        }

        if ($user->Verified == false) {
            var_dump($user);
            $response[] = "Confirm your email.";
            echo json_encode($response);
            return;
        }

        if (!password_verify($model->Password,$user->PasswordHash))
        {
            $response[] = "Wrong credentials.";
            echo json_encode($response);
            return;
        }

        $_SESSION["User"] = $user;

        $response['code'] = 1;
        $response[] = "Login successful";
        echo json_encode($response);
    }

    public function FindUsers(string $searchString)
    {
        $response = array();
        $response['code'] = 0;
        $currentUser = $_SESSION["User"];

        if (!$currentUser) {
            $response[] = "User not Unauthorized";
            echo json_encode($response);
            return;
        }

        $users = $this->userRepository->SearchUsers($searchString);
        foreach ($users as $user)
        {
            unset($user->PasswordHash);
            unset($user->Verified);
        }

        $response['code'] = 1;
        $response[] = $users;
        echo json_encode($response);
    }

    public function GetCurrent()
    {
        $currentUser = $_SESSION["User"];

        if (!$currentUser) {
            $response[] = "User not Unauthorized";
            echo json_encode($response);
            return;
        }

        echo json_encode($currentUser);
    }
}