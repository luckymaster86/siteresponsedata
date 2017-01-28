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

    
    private function getHtml() {
        return $this->html;
    }
    public function setHtml($html) {
        $this->html = $html;
    }
}
