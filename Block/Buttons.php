<?php
/**
 * @copyright Absolute Commerce Ltd.
 * @license https://abscom.co/terms
 */
namespace Absolute\CacheBust\Block;

use Magento\Backend\Block\Template;

class Buttons extends Template
{
    /**
     * @return string
     */
    public function getCacheBustAllUrl()
    {
        return $this->getUrl('Absolute_CacheBust/action/allAction');
    }

    /**
     * @return string
     */
    public function getCacheBustStaticUrl()
    {
        return $this->getUrl('Absolute_CacheBust/action/staticAction');
    }

    /**
     * @return string
     */
    public function getCacheBustMediaUrl()
    {
        return $this->getUrl('Absolute_CacheBust/action/mediaAction');
    }
}
