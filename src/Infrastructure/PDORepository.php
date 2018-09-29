<?php

namespace Notepad\Infrastructure;

abstract class PDORepository{

    protected $pdo;

    protected function genericExecute($command, $array){
        
        $this->pdo->beginTransaction();

        try {

            $query = $this->pdo->prepare($command);
            $res = $query->execute($array); 

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollback();
        }

        return $res;
    }

}