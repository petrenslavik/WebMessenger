<?php


namespace Messenger\Database\Repositories;


use Messenger\Database\Interfaces\IConversationRepository;
use Messenger\Models\Conversation;
use PDO;

class ConversationRepository extends BaseRepository implements IConversationRepository
{
    public function __construct()
    {
        parent::__construct("Conversations", "Messenger\Models\Conversation");
    }

    public function GetByUserId($userId)
    {
        $stmt = $this->_pdo->prepare("Select * from {$this->_table} where FirstUserId = :firstId or SecondUserId = :secondId");
        $stmt->execute(array('firstId'=>$userId,'secondId'=>$userId));
        return $stmt->fetchAll(PDO::FETCH_CLASS,$this->_entityClass);
    }

    public function GetByEntity(Conversation $model)
    {
        $stmt = $this->_pdo->prepare("Select * from {$this->_table} where FirstUserId = :firstId and SecondUserId = :secondId or  FirstUserId = :secondId and SecondUserId = :firstId");
        $stmt->execute(array('firstId'=>$model->FirstUserId,'secondId'=>$model->SecondUserId));
        return $stmt->fetchAll(PDO::FETCH_CLASS,$this->_entityClass);
    }
}