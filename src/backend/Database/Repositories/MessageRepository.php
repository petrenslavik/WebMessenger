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
        $stmt = $this->_pdo->prepare("Select * from {$this->_table} where ConversationId = :conversationId ORDER BY SendDateTime DESC Limit 1");
        $stmt->execute(array('conversationId' => $conversationId));
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->_entityClass);
        return $stmt->fetch();
    }

    public function GetAllMessagesByConversationId($conversationId)
    {
        $stmt = $this->_pdo->prepare("Select * from {$this->_table} where ConversationId = :conversationId ORDER BY SendDateTime");
        $stmt->execute(array('conversationId' => $conversationId));
        return $stmt->fetchAll(PDO::FETCH_CLASS, $this->_entityClass);
    }

    public function GetMessagesFromDate($date, $userId)
    {
        $sql = "Select * from {$this->_table} join conversations on conversations.Id={$this->_table}.ConversationId join messagetext on messagetext.MessageId ={$this->_table}.Id  where (conversations.FirstUserId like :id1 or conversations.SecondUserId like :id2) and SendDateTime>:date and SenderId not like :id3 ORDER BY SendDateTime";
        $stmt = $this->_pdo->prepare($sql);
        $stmt->execute(array('id1' => $userId, 'id2' => $userId, 'date' => $date,'id3' => $userId));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}