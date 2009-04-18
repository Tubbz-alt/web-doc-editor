<?php

/**
 * A class for read News form http://news.php.net
 *
 */
class NewsReader {
    
    /**
     * The lang
     *
     * @var string
     */
    private $lang;
    
    /**
     * Initialise
     *
     * @param string $lang
     */
    function __construct($lang)
    {
        $this->lang   = $lang;
    }
    
    /**
     * Get all news for this LANG.
     * 
     * @return An indexed array (id, title, description, link, pubDate) readable by ExtJs
     */
    function getLastNews() {

        $result = array();

        $url = 'http://news.php.net/group.php?format=rss&group=php.doc';

        if ($this->lang != 'en') {
            $url .= '.' . strtolower(str_replace('_', '-', $this->lang));
        }

        $xml = new SimpleXMLElement(file_get_contents($url));

        $channel = $xml->channel;

        $i = 0;
        foreach ($channel->item as $item) {
            $result[$i]['id'] = $i;
            $result[$i]['title'] = (string) $item->title;
            $result[$i]['description'] = preg_replace('/(<a href[^>]+">)([^>]+)(<\/a>)/', "$2", (string) $item->description);
            $result[$i]['link'] = (string) $item->link;
            $result[$i]['pubDate'] = date('Y/m/d H:i:s', strtotime((string) $item->pubDate));
            $i++;
        }
        return $result;

    }
    
}