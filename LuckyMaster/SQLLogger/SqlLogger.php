<?php
namespace LuckyMaster\SQLLogger;

/**
 * Description of SqlLogger
 *
 * @author master
 */
class SqlLogger {
    private $db;
    
    public function __construct(\PDO $pdo) {
        $this->db = $pdo;
    }
    
    //добавление данных по ссылкам
    public function logLinks($links){
        $sql = "INSERT IGNORE INTO siteLinks(hash, url, firstPageWhereFound) values (:hash, :url, :firstPageWhereFound);";
        
        $stmt = $this->db->prepare($sql);
        $this->db->beginTransaction();
        foreach ($links as $link) {
            $stmt->execute([':hash' => $link->hash , ':url' => $link->url, ':firstPageWhereFound' => $link->firstPageWhereFound]);
        }
        $this->db->commit();
    }
    
}
