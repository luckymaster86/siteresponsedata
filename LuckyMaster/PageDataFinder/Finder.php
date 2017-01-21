<?php
namespace LuckyMaster\PageDataFinder;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Description of urlFinder
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
    public function findLinksUrls() {
        $crawler = new Crawler($this->getHtml(),'http://www.example.com');
        $result = [];
        foreach ( $crawler->filter('a')->each(
                                                function ($node){
                                                    return $node;
                                                }
                                             ) as $url ) {
            $href = $url->attr('href');
            if(!in_array($href, $result)) {
                $result[] = $href;
            }
        }
        return $result;
    }
    
    /*
     * поиск адресов всех фреймов
     */
    public function findFramesSrc() {
        $result  = []; 

        
        // для frame
        $crawler = new Crawler($this->getHtml(),'http://www.example.com');
        foreach ( $crawler->filter('frame')->each(
                                                function ($node){
                                                    return $node;
                                                }
                                             ) as $frame ) {
            $src = $frame->attr('src');
            if(!in_array($src, $result)) {
                $result[] = $src;
            }
        }
        unset($crawler);
        
        //для iframe
        $crawler = new Crawler($this->getHtml(),'http://www.example.com');
        foreach ( $crawler->filter('iframe')->each(
                                                function ($node){
                                                    return $node;
                                                }
                                             ) as $frame ) {
            $src = $frame->attr('src');
            if(!in_array($src, $result)) {
                $result[] = $src;
            }
        }
        unset($crawler);
        
        return $result;
    }
    
    //поиск всех скриптов
    public function findScriptsSrc() {
        $crawler = new Crawler($this->getHtml(),'http://www.example.com');
        $result = [];
        foreach ( $crawler->filter('script')->each(
                                                function ($node){
                                                    return $node;
                                                }
                                             ) as $script ) {
            $src = $script->attr('src');
            $text = $script->text();
            $hash = md5($text);
            $textLength = strlen($text);
            $result[] = ['src' => $src, 'text' => $text, 'hash' => $hash, 'textLength' => $textLength];
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
