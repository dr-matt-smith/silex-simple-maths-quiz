<?php

namespace Itb\Model\Module;
use Mattsmithdev\PdoCrudRepo\DatabaseTableRepository;

/**
 * Class ModuleResultRepository
 * class to store and serve Book objects (bit like a memory-only database ...)
 * @package Itb\Model
 */
class ModuleResultRepository extends DatabaseTableRepository
{
    public function __construct()
    {
        $namespace = 'Itb\Model\Module';
        $classNameForDbRecords = 'ModuleResult';
        $tableName = 'module_results';
        parent::__construct($namespace, $classNameForDbRecords, $tableName);
    }

}