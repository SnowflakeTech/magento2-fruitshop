<?php

namespace TT\RssNews\Block;

use Magento\Framework\View\Element\Template;

class RssNews extends Template
{
    protected $feedUrl = 'https://vnexpress.net/rss/kinh-doanh.rss';

    public function getRssFeed()
    {
        $rss = simplexml_load_file($this->feedUrl);
        $newsItems = [];
        if ($rss) {
            foreach ($rss->channel->item as $item) {
                $newsItems[] = [
                    'title' => (string)$item->title,
                    'link' => (string)$item->link,
                    'description' => (string)$item->description,
                    'pubDate' => (string)$item->pubDate
                ];
            }
        }
        return $newsItems;
    }
}
