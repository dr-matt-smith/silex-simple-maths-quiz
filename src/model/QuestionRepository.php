<?php

namespace Itb\Model;
use Mattsmithdev\PdoCrudRepo\DatabaseTableRepository;
use Mattsmithdev\PdoCrudRepo\DatabaseManager;

class QuestionRepository extends DatabaseTableRepository
{
    public function __construct()
    {
        $namespace = 'Itb\Model';
        $classNameForDbRecords = 'Question';
        $tableName = 'questions';
        parent::__construct($namespace, $classNameForDbRecords, $tableName);
    }


    public function deleteAll()
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = '';
        $sql .= 'DELETE FROM questions WHERE 1';

        $statement = $connection->prepare($sql);
        $success = $statement->execute();

        return $success;

    }


    public function resetAutoIncrement()
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = '';
        $sql .= 'ALTER TABLE questions AUTO_INCREMENT = 1';

        $statement = $connection->prepare($sql);
        $success = $statement->execute();

        return $success;
    }

    public function resetDatabaseTable()
    {
        $this->deleteAll();
        $this->resetAutoIncrement();
    }

}