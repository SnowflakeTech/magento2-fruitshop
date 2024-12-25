<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace TT\Hello\Block\Html;

/**
 * Links list block
 */
class Clearfix extends \Magento\Framework\View\Element\Template
{  

    /**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (false != $this->getTemplate()) {
            return parent::_toHtml();
        }

        $html = '';
        $html = '<div class="clearfix  '. $this->escapeHtml(
                $this->getCssClass()
            ).'"></div>';
       
        return $html;
    }
}
