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
            $stmt->execute(array(':hash' => $link->hash , ':url' => $link->url, ':firstPageWhereFound' => $link->firstPageWhereFound));
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
            $stmt->execute(array(':hash' => $script->hash, ':src' => $script->src, ':text' => $script->text, ':firstPageWhereFound' => $script->firstPageWhereFound));
            
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
            $stmt->execute(array(':hash' => $frame->hash, ':src' => $frame->src, ':firstPageWhereFound' => $frame->firstPageWhereFound));
        }
        $this->db->commit();
    }
    
    /*
     * добавление данных о img
     */
    public function logImgs($images) {
        if(empty($images)){
            return;
        }
        
        $sql = "INSERT IGNORE INTO siteImgs(hash, src, firstPageWhereFound) values (:hash, :src, :firstPageWhereFound)";
        
        $stmt = $this->db->prepare($sql);
        $this->db->beginTransaction();
        foreach ($images as $img) {
            $stmt->execute(array(':hash' => $img->hash,
                                 ':src' => $img->src,
                                 ':firstPageWhereFound' => $img->firstPageWhereFound));
        }
        $this->db->commit();
    }
    
    /*
     * добавление данных о embed
     */
    public function logEmbeds($embeds) {
        if(empty($embeds)){
            return;
        }
        
        $sql = "INSERT IGNORE INTO siteEmbeds(hash, src, type, pluginspage, firstPageWhereFound) values (:hash, :src, :type, :pluginspage, :firstPageWhereFound)";
        
        $stmt = $this->db->prepare($sql);
        $this->db->beginTransaction();
        foreach ($embeds as $emb) {
            $stmt->execute(array(':hash' => $emb->hash,
                                 ':src' => $emb->src,
                                 ':type' => $emb->type,
                                 ':pluginspage' => $emb->pluginspage,
                                 ':firstPageWhereFound' => $emb->firstPageWhereFound));
        }
        $this->db->commit();
    }
    
    
    /*
     * добавление данных о object
     */
    public function logObjects($objects) {
        if(empty($objects)){
            return;
        }
        
        $sql = "INSERT IGNORE INTO siteObjects(hash, data, type, firstPageWhereFound) values (:hash, :data, :type, :firstPageWhereFound)";
        
        $stmt = $this->db->prepare($sql);
        $this->db->beginTransaction();
        foreach ($objects as $obj) {
            $stmt->execute(array( ':hash' => $obj->hash,
                                  ':data' => $obj->data,
                                  ':type' => $obj->type,
                                  ':firstPageWhereFound' => $obj->firstPageWhereFound));
        }
        $this->db->commit();
    }
        
}
