<?php

namespace Core;

use PDO;
// Connect to database with PDO
//connect to database and execute query

class Database
{

  public $connection;
  public $statement;

  public function __construct()
  {

    $config = [
      'host' => 'localhost',
      'port' => 3306,
      'dbname' => 'ems',
      'charset' => 'utf8mb4',
    ];
    $username = 'root';
    $password = '';

    //$dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset={$config['charset']}"; 
    // DSN: Data Source Name (host, dbname, charset)

    $dsn = 'mysql:' . http_build_query($config, '', ';');

    $this->connection = new PDO($dsn, $username, $password, [
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
  }
  public function query($query, $params = [])
  {

    $this->statement = $this->connection->prepare($query); //1.write statement to prepare
    $this->statement->execute($params); //2.execute the statement

    return $this;
  }

  public function find()
  {
    return $this->statement->fetch();
  }

  public function getAll()
  {
    return $this->statement->fetchAll();
  }

  public function findOrFail()
  {
    $result = $this->find();
    if (!$result) {
      abort();
    }
    return $result;
  }

  public function lastInsertId()
  {
    return $this->connection->lastInsertId();
  }
}
