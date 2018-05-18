<?php
/**
 * @copyright Absolute Commerce Ltd.
 * @license https://abscom.co/terms
 */
namespace Absolute\CacheBust\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    const XML_PATH_STATIC_ENABLED  = 'absolute_cachebust/static/is_enabled';
    const XML_PATH_STATIC_TEMPLATE = 'absolute_cachebust/static/template';
    const XML_PATH_STATIC_VALUE    = 'absolute_cachebust/static/value';

    const XML_PATH_MEDIA_ENABLED  = 'absolute_cachebust/media/is_enabled';
    const XML_PATH_MEDIA_TEMPLATE = 'absolute_cachebust/media/template';
    const XML_PATH_MEDIA_VALUE    = 'absolute_cachebust/media/value';

    const DEFAULT_TEMPLATE = 'version%s';
    const DEFAULT_VALUE    = '19700101010000';

    /** @var ScopeConfigInterface */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig,
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return bool
     */
    public function isStaticEnabled()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_STATIC_ENABLED) == 1;
    }

    /**
     * @return string
     */
    public function getStaticTemplate()
    {
        $template = trim($this->scopeConfig->getValue(self::XML_PATH_STATIC_TEMPLATE));
        
        if (empty($template)) {
            $template = self::DEFAULT_TEMPLATE;
        }

        return $template;
    }

    /**
     * @return string
     */
    public function getStaticValue()
    {
        $value = trim($this->scopeConfig->getValue(self::XML_PATH_STATIC_VALUE));
        
        if (empty($value)) {
            $value = self::DEFAULT_VALUE;
        }

        return $value;
    }

    /**
     * @return bool
     */
    public function isMediaEnabled()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_MEDIA_ENABLED) == 1;
    }

    /**
     * @return string
     */
    public function getMediaTemplate()
    {
        $template = trim($this->scopeConfig->getValue(self::XML_PATH_MEDIA_TEMPLATE));
        
        if (empty($template)) {
            $template = self::DEFAULT_TEMPLATE;
        }

        return $template;
    }

    /**
     * @return string
     */
    public function getMediaValue()
    {
        $value = trim($this->scopeConfig->getValue(self::XML_PATH_MEDIA_VALUE));
        
        if (empty($value)) {
            $value = self::DEFAULT_VALUE;
        }
        
        return $value;
    }
}
