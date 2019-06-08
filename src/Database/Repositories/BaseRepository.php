<?php


namespace Messenger\Database\Repositories;

use PDO;
use Messenger\Database\Interfaces\IBaseRepository;
use Messenger\Database\Database;

class BaseRepository implements IBaseRepository
{
    /** @var PDO $object */
    protected $_pdo;
    protected $_table;
    protected $_entityClass;

    public function __construct($table, $entityClass)
    {
        $this->_pdo = Database::getInstance();
        $this->_table = $table;
        $this->_entityClass = $entityClass;
    }

    public function GetById($id)
    {
        $stmt = $this->_pdo->prepare("Select * from {$this->_table} where Id = :id");
        $stmt->execute(array('id'=>$id));
        $stmt->setFetchMode(PDO::FETCH_CLASS,$this->_entityClass);
        return $stmt->fetch();
    }

    public function Insert($entity)
    {
        $row = get_object_vars($entity);
        $fieldsList = array_keys($row);
        $valuesList = array_values($row);
        $fieldsString = implode(',', $fieldsList);
        $params = [];
        for($i = 0; $i < count($fieldsList); $i++)
            array_push($params, '?');
        $paramsString = implode(',', $params);
        $sql = "INSERT INTO {$this->_table} ({$fieldsString}) VALUES($paramsString)";
        $stmt = $this->_pdo->prepare($sql);
        $stmt->execute($valuesList);
    }

    public function Delete($id)
    {
        $sql = "Delete From {$this->_table} WHERE id = :id";
        $this->_pdo->prepare($sql)->execute(array('id'=>$id));
    }

    public function GetAll()
    {
        $stmt = $this->_pdo->prepare("Select * from {$this->_table}");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS,$this->_entityClass);
    }

    public function GetCount()
    {
        $stmt = $this->_pdo->prepare("SELECT count(Id) FROM {$this->_table}");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function GetSet($offset, $amount)
    {
        $stmt = $this->_pdo->prepare("Select * from {$this->_table} LIMIT ?,?");
        $stmt->bindParam(1, $offset,PDO::PARAM_INT);
        $stmt->bindParam(2, $amount,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS,$this->_entityClass);
    }

    public function Update($entity)
    {
        $row = get_object_vars($entity);
        $fieldsList = array_keys($row);
        $valuesList = array_values($row);
        $arr = [];
        for($i = 0; $i < count($fieldsList); $i++)
        {
            array_push($arr, "{$fieldsList[$i]} = ?");
        }
        $setString = implode(",", $arr);
        $sql = "UPDATE {$this->_table} SET {$setString} WHERE Id = ?";
        echo $sql;
        $st = $this->_pdo->prepare($sql);
        array_push($valuesList, $$entity->Id);
        $st->execute($valuesList);
    }
}