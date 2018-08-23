<?php
namespace Ergosense\Repository;

use Aura\SqlQuery\QueryFactory;

class CompanyRepository
{
  const COMPANY_TABLE = 'company';

  static private $cols = ['id', 'name', 'active'];

  static private $autoKey = 'id';

  public function __construct(\PDO $pdo, QueryFactory $query)
  {
    $this->pdo = $pdo;
    $this->query = $query;
  }

  private function fetch($select)
  {
    // TODO abstract the execution from the fetch
    $stmt = $this->pdo->prepare($select->getStatement());
    $stmt->execute($select->getBindValues());
    return $stmt->fetch(\PDO::FETCH_ASSOC);
  }

  private function fetchAll($select)
  {
    $stmt = $this->pdo->prepare($select->getStatement());
    $stmt->execute($select->getBindValues());
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  private function execute($insert)
  {
    $stmt = $this->pdo->prepare($insert->getStatement());
    $stmt->execute($insert->getBindValues());
    return $this->pdo->lastInsertId();
  }

  public function findById($id)
  {
    $select = $this->query
      ->newSelect()
      ->cols(static::$cols)
      ->from(static::COMPANY_TABLE)
      ->where('id = :id')
      ->bindValue('id', $id);

    return $this->fetch($select);
  }

  public function search()
  {
    $select = $this->query
      ->newSelect()
      ->cols(static::$cols)
      ->from(static::COMPANY_TABLE);

    // TODO pagination
    return $this->fetchAll($select);
  }

  public function save($body)
  {
    $cols = array_diff(static::$cols, [ static::$autoKey ]);

    $insert = $this->query
      ->newInsert()
      ->into(static::COMPANY_TABLE)
      ->cols($cols)
      ->bindValues($body);

    return $this->execute($insert);
  }
}