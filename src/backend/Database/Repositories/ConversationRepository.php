<?php


namespace Messenger\Database\Repositories;


use Messenger\backend\Database\Interfaces\IConversationRepository;
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
        $stmt->setFetchMode(PDO::FETCH_CLASS,$this->_entityClass);
        return $stmt->fetch();
    }
}