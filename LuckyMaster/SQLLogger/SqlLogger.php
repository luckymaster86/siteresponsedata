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
    
    /*
     * добавление данных по ссылкам
     */
    public function logLinks($links){
        if(empty($links)){
            return;
        }
        
        $sql = "INSERT IGNORE INTO siteLinks(hash, url, firstPageWhereFound) values (:hash, :url, :firstPageWhereFound)";
        
        $stmt = $this->db->prepare($sql);
        $this->db->beginTransaction();
        foreach ($links as $link) {
            $stmt->execute([':hash' => $link->hash , ':url' => $link->url, ':firstPageWhereFound' => $link->firstPageWhereFound]);
        }
        $this->db->commit();
    }
    
    /*
     * добавление данных о скриптах
     */
    public function logScripts($scripts) {
        if(empty($scripts)){
            return;
        }
        
        $sql = "INSERT IGNORE INTO siteScripts(hash, src, text, firstPageWhereFound) values (:hash, :src, :text, :firstPageWhereFound)";
        
        $stmt = $this->db->prepare($sql);
        $this->db->beginTransaction();
        foreach ($scripts as $script) {
            $stmt->execute([':hash' => $script->hash, ':src' => $script->src, ':text' => $script->text, ':firstPageWhereFound' => $script->firstPageWhereFound]);
            
        }
        $this->db->commit();
    }
    
    /*
     * добавление данных о фреймах
     */
    public function logFrames($frames) {
        if(empty($frames)){
            return;
        }
        
        $sql = "INSERT IGNORE INTO siteFrames(hash, src, firstPageWhereFound) values (:hash, :src, :firstPageWhereFound)";
        
        $stmt = $this->db->prepare($sql);
        $this->db->beginTransaction();
        foreach ($frames as $frame) {
            $stmt->execute([':hash' => $frame->hash, ':src' => $frame->src, ':firstPageWhereFound' => $frame->firstPageWhereFound]);
        }
        $this->db->commit();
    }
}
