<?php

namespace TT\RssNews\Block;

use Magento\Framework\View\Element\Template;

class NewsList extends Template
{
    protected $_rssReader;

    public function __construct(
        Template\Context $context,
        \TT\RssNews\Helper\RssReader $rssReader,
        array $data = []
    ) {
        $this->_rssReader = $rssReader;
        parent::__construct($context, $data);
    }

    public function getNews()
    {
        return $this->_rssReader->getRssFeed();
    }
}
