<?php
namespace Ergosense\Repository;

use Aura\SqlQuery\QueryFactory;


class UserRepository
{
  const USER_TABLE = 'user';
  private static $cols = ['id', 'email', 'password', 'role', 'active'];

  public function __construct(\PDO $pdo, QueryFactory $query)
  {
    $this->pdo = $pdo;
    $this->query = $query;
  }

  private function fetch($select)
  {
    $stmt = $this->pdo->prepare($select->getStatement());
    $stmt->execute($select->getBindValues());
    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }

  public function findById($id)
  {
    $select = $this->query
      ->newSelect()
      ->cols(static::$cols)
      ->from(static::USER_TABLE)
      ->where('id = :id')
      ->bindValue('id', $id);

    return $this->fetch($select);
  }

  public function findByEmail($email)
  {
    $select = $this->query
      ->newSelect()
      ->cols(static::$cols)
      ->from(static::USER_TABLE)
      ->where('email = :email')
      ->bindValue('email', $email);

    return $this->fetch($select);
  }
}