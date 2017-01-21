<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SqlLogger
 *
 * @author master
 */
class SqlLogger {
    private $db;
    
    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }
    
    //добавление данных по ссылкам
    public function logLinks($links){
        $sql = "INSERT INGNORE INTO url (hash, url, firstPageWhereFound) values (:hash, :url, :firstPageWhereFound);";
        $stmt = $this->db->prepare($sql);
        foreach ($links as $link) {
            $stmt->execute([':hash' => $link->hash , ':url' => $link->url, ':firstPageWhereFound' => $link->firstPageWhereFound]);
        }
    }
    
}
