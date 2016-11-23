<?php
namespace Absolute\CDNCacheBust\Block;

use Magento\Backend\Block\Template;

class Buttons extends Template
{
    /**
     * @return string
     */
    public function getCacheBustAllUrl()
    {
        return $this->getUrl('Absolute_CDNCacheBust/action/allAction');
    }

    /**
     * @return string
     */
    public function getCacheBustStaticUrl()
    {
        return $this->getUrl('Absolute_CDNCacheBust/action/staticAction');
    }

    /**
     * @return string
     */
    public function getCacheBustMediaUrl()
    {
        return $this->getUrl('Absolute_CDNCacheBust/action/mediaAction');
    }
}
