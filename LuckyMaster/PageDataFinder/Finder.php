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
    public function findFramesUrls() {
        $crawler = new Crawler($this->getHtml(),'http://www.example.com');
        $result = [];
        foreach ( $crawler->filter('frame')->each(
                                                function ($node){
                                                    return $node;
                                                }
                                             ) as $url ) {
            $href = $url->attr('src');
            if(!in_array($href, $result)) {
                $result[] = $href;
            }
        }
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
                                             ) as $url ) {
            $href = $url->attr('src');
            if(!in_array($href, $result)) {
                $result[] = $href;
            }
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
