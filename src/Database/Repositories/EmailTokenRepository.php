<?php


namespace Messenger\Database\Repositories;


use Messenger\Database\Interfaces\IEmailTokenRepository;
use Messenger\Models\EmailToken;
use PDO;

class EmailTokenRepository extends BaseRepository implements IEmailTokenRepository
{
    public function __construct()
    {
        parent::__construct("EmailTokens", "Messenger\Models\EmailToken");
    }

    public function GetByToken($token):EmailToken
    {
        $stmt = $this->_pdo->prepare("Select * from {$this->_table} where Token = :token");
        $stmt->execute(array('token'=>$token));
        $stmt->setFetchMode(PDO::FETCH_CLASS,$this->_entityClass);
        return $stmt->fetch();
    }
}