<?php


namespace Messenger\Database\Repositories;


use Messenger\Database\Interfaces\ITextMessageRepository;
use PDO;

class TextMessageRepository extends BaseRepository implements ITextMessageRepository
{
    public function __construct()
    {
        parent::__construct("messagetext", "Messenger\Models\TextMessage");
    }

    public function GetByMessageId($id)
    {
        $stmt = $this->_pdo->prepare("Select * from {$this->_table} where MessageId = :id");
        $stmt->execute(array('id'=>$id));
        $stmt->setFetchMode(PDO::FETCH_CLASS,$this->_entityClass);
        return $stmt->fetch();
    }
}