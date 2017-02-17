<?php
/**
 * @copyright 2017 Absolute Commerce Ltd. (https://abscom.co/terms)
 */
namespace Absolute\CacheBust\Plugin;

use Magento\Framework\UrlInterface;
use Magento\Framework\Url\ScopeInterface;
use Absolute\CacheBust\Model\Config;

class Signature
{
    /** @var Config */
    private $config;

    /**
     * @param Config $config
     */
    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    /**
     * @param ScopeInterface $subject
     * @param \Closure $proceed
     * @param string $type
     * @param null $secure
     * @return string
     */
    public function aroundGetBaseUrl(
        ScopeInterface $subject,
        \Closure $proceed,
        $type = UrlInterface::URL_TYPE_LINK,
        $secure = null
    ) {
        $baseUrl = $proceed($type, $secure);
        
        switch ($type) {
            case UrlInterface::URL_TYPE_STATIC:
                if ($this->config->isStaticEnabled()) {
                    $value = $this->config->getStaticValue();
                    $template = $this->config->getStaticTemplate();
                    $baseUrl .= $this->renderSignature($template, $value);
                }
                break;
            
            case UrlInterface::URL_TYPE_MEDIA:
                if ($this->config->isMediaEnabled()) {
                    $value = $this->config->getMediaValue();
                    $template = $this->config->getMediaTemplate();
                    $baseUrl .= $this->renderSignature($template, $value);
                }
                break;
            
            default:
                break;
        }
        
        return $baseUrl;
    }

    /**
     * @param string $template
     * @param string $value
     * @return string
     */
    private function renderSignature($template, $value)
    {
        $signature = sprintf($template, $value);
        $signature = trim($signature, '/') . '/';
        
        return $signature;
    }
}
