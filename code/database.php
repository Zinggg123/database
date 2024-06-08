<?php

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct($host, $db, $user, $pass)
    {
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("数据库连接失败: " . $e->getMessage());
        }
    }

    public static function getInstance($host = 'localhost', $db = 'milktea', $user = 'root', $pass = '2212165')
    {
        if (null === self::$instance) {
            self::$instance = new Database($host, $db, $user, $pass);
        }
        return self::$instance;
    }

    // 执行SQL查询
    public function query($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    // 获取所有数据
    public function getAll($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 获取单条数据
    public function getOne($sql, $params = [])
    {
        $stmt = $this->query($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 执行更新或插入操作
    public function executeQuery($sql, $params = [])
    {
        return $this->pdo->exec($sql);
    }

    public function prepareAndExecute($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function prepare($sql, $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        return $stmt;
    }
}

?>