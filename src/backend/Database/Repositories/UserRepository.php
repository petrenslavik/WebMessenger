<?php


namespace Messenger\Database\Repositories;

use Messenger\Database\Interfaces\IUserRepository;
use Messenger\Models\User;
use PDO;

class UserRepository extends BaseRepository implements IUserRepository
{
    public function __construct()
    {
        parent::__construct("Users", "Messenger\Models\User");
    }

    public function GetUserByEmail($email)
    {
        $stmt = $this->_pdo->prepare("Select * from {$this->_table} where Email = :email");
        $stmt->execute(array('email'=>$email));
        $stmt->setFetchMode(PDO::FETCH_CLASS,$this->_entityClass);
        return $stmt->fetch();
    }

    public function GetUserByUsername($username)
    {
        $stmt = $this->_pdo->prepare("Select * from {$this->_table} where Username = :username");
        $stmt->execute(array('username'=>$username));
        $stmt->setFetchMode(PDO::FETCH_CLASS,$this->_entityClass);
        return $stmt->fetch();
    }
}