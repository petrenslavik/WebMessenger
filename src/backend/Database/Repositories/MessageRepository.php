<?php


namespace Messenger\Database\Repositories;


use Messenger\Database\Interfaces\IMessageRepository;
use PDO;

class MessageRepository extends BaseRepository implements IMessageRepository
{
    public function __construct()
    {
        parent::__construct("Messages", "Messenger\Models\Message");
    }

    public function GetLastMessageByConversationId($conversationId)
    {
        $stmt = $this->_pdo->prepare("Select * from {$this->_table} where ConversationId = :conversationId Limit 1 Order By SendDateTime");
        $stmt->execute(array('conversationId'=>$conversationId));
        $stmt->setFetchMode(PDO::FETCH_CLASS,$this->_entityClass);
        return $stmt->fetch();
    }
}