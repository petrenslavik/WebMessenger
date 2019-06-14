<?php


namespace Messenger\Database\Repositories;


use Messenger\Database\Interfaces\IFileMessageInterface;
use PDO;

class FileMessageRepository extends BaseRepository implements IFileMessageInterface
{
    public function __construct()
    {
        parent::__construct("files", "Messenger\Models\FileMessage");
    }

    public function GetByMessageId($id)
    {
        $stmt = $this->_pdo->prepare("Select * from {$this->_table} where MessageId = :id");
        $stmt->execute(array('id'=>$id));
        $stmt->setFetchMode(PDO::FETCH_CLASS,$this->_entityClass);
        return $stmt->fetch();
    }
}