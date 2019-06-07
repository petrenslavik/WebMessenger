<?php


namespace Messenger\Database;


use Exception;
use PDO;
use PDOException;

class Database
{
    protected const configDirectory = 'Config/';
    protected const configFilename = 'db.php';

    private static $_instance = null;
    protected $pdo;
    protected $name;
    protected $host;
    protected $user;
    protected $password;

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new static();
            self::$_instance->connect();
        }
        return self::$_instance->pdo;
    }

    protected function connect()
    {
        $this->includeConfig();
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];
        try {
            $this->pdo = new PDO('mysql:dbname=' . $this->name . ';host=' . $this->host, $this->user, $this->password, $options);
        } catch (PDOException $ex) {
            switch ($ex->getCode()) {
                case 1049:
                    throw new Exception("Database not found");
                    break;
                case 1045:
                    throw new Exception("Username or password is incorrect");
                    break;
                default:
                    throw new PDOException($ex);
            }
        }
    }

    protected function includeConfig()
    {
        $configFile = $this::configDirectory . $this::configFilename;
        if (!is_file($configFile)) {
            throw new Exception("File `$configFile` not found");
        }
        include_once $configFile;

        $this->name = DB_NAME;
        $this->host = DB_HOST;
        $this->user = DB_USER;
        $this->password = DB_PASSWORD;
    }

}