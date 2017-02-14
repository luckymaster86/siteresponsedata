<?php
namespace LuckyMaster\PageDataFinder;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Description of Finder
 *
 * @author master
 */
class Finder {
    private $html;

    public function __construct() {
        
    }
    /*
     * поиск всех ссылок
     */
    public function findLinks() {
        $crawler = new Crawler($this->getHtml(),'http://www.example.com');
        $result = array();
        foreach ( $crawler->filter('a')->each(
                                                function ($node){
                                                    return $node;
                                                }
                                             ) as $url ) {
            $href = $url->attr('href');
            if(!in_array($href, $result)) {
                $link = new \stdClass();
                $link->url = $href;
                $link->hash = md5($href) . '|' . strlen($href);
                $result[] = $link;
                
            }
        }
        return $result;
    }
    
    /*
     * поиск адресов всех фреймов
     */
    public function findFrames() {
        $result  = array(); 

        
        // для frame
        $crawler = new Crawler($this->getHtml(),'http://www.example.com');
        foreach ( $crawler->filter('frame')->each(
                                                function ($node){
                                                    return $node;
                                                }
                                             ) as $frame ) {
          
            
            
            
            $f = new \stdClass();
            $f->src = $frame->attr('src');
            $f->hash = md5($f->src) . '|' . strlen($f->src);
            $result[] = $f;
        }
        unset($crawler);
        
        //для iframe
        $crawler = new Crawler($this->getHtml(),'http://www.example.com');
        foreach ( $crawler->filter('iframe')->each(
                                                function ($node){
        
                                                    return $node;
                                                }
                                             ) as $frame ) {                     
            $f = new \stdClass();
            $f->src = $frame->attr('src');
            $f->hash = md5($f->src) . '|' . strlen($f->src);
            
            if(empty($f->src)){
                $f->hash = md5(uniqid()) . '|' .  'noSrc';
            }
            
            $result[] = $f;
        }
        unset($crawler);
        
        return $result;
    }
    
    /*
     * поиск всех скриптов
     */
    public function findScripts() {
        $crawler = new Crawler($this->getHtml(),'http://www.example.com');
        $result = array();
        foreach ( $crawler->filter('script')->each(
                                                function ($node){
                                                    return $node;
                                                }
                                             ) as $script ) {
            $s = new \stdClass();
            $s->src = $script->attr('src');
            $s->text = $script->text();
            $s->textLength = strlen($s->text);
            $s->hash = md5($s->src . $s->text) . '|' . strlen($s->src) . '|' . $s->textLength;
            $result[] = $s;
        }
        return $result;
    }

    /*
     * поиск всех картинок
     */
    public function findImgs() {
        $crawler = new Crawler($this->getHtml(),'http://www.example.com');
        $result = array();
        foreach ( $crawler->filter('img')->each(
                                                function ($node){
                                                    return $node;
                                                }
                                             ) as $img ) {
            $i = new \stdClass();
            $i->src = $img->attr('src');
            $i->hash = md5($i->src) . '|' . strlen($i->src) ;
            $result[] = $i;
        }
        return $result;
    }
    

    /*
     * поиск всех embed
     */
    public function findEmbeds() {
        $crawler = new Crawler($this->getHtml(),'http://www.example.com');
        $result = array();
        foreach ( $crawler->filter('embed')->each(
                                                function ($node){
                                                    return $node;
                                                }
                                             ) as $emb ) {
            $e = new \stdClass();
            $e->src = $emb->attr('src');
            $e->type = $emb->attr('type');
            $e->pluginspage = $emb->attr('pluginspage');
            $e->hash = md5($e->src . $e->type . $e->pluginspage) . '|' . strlen($e->src . $e->type . $e->pluginspage) ;
            $result[] = $e;
        }
        return $result;
    }
    

    /*
     * поиск всех object
     */
    public function findObjects() {
        $crawler = new Crawler($this->getHtml(),'http://www.example.com');
        $result = array();
        foreach ( $crawler->filter('object')->each(
                                                function ($node){
                                                    return $node;
                                                }
                                             ) as $object ) {
            $o = new \stdClass();
            
            $o->data = $object->attr('data');
            $o->type = $object->attr('type');
            $o->hash = md5( $o->data . $o->type) . '|' . strlen($o->data . $o->type) ;
            $result[] = $o;
        }
        return $result;
    }
    
    
    private function getHtml() {
        return $this->html;
    }
    public function setHtml($html) {
        $this->html = $html;
    }
}
