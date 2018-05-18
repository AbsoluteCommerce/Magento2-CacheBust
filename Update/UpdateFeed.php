<?php
/**
 * @copyright Absolute Commerce Ltd.
 * @license https://abscom.co/terms
 */
namespace Absolute\CacheBust\Update;

use Magento\AdminNotification\Model\Feed as MagentoFeed;

class UpdateFeed extends MagentoFeed
{
    const FEED_TIMEOUT         = 5;
    const XML_FEED_ENABLED     = 'absolute_cachebust/update/is_enabled';
    const XML_FEED_URL_PATH    = 'absolute_cachebust/update/feed_url';
    const CACHE_KEY_LAST_CHECK = 'absolute_cachebust_update_last_check';

    /**
     * @inheritdoc
     */
    public function checkUpdate()
    {
        /** @see \Magento\Config\Model\Config\Source\Yesno */
        if ($this->_backendConfig->getValue(self::XML_FEED_ENABLED) != '1') {
            return $this;
        }
        
        return parent::checkUpdate();
    }

    /**
     * @return bool|\SimpleXMLElement
     */
    public function getFeedData()
    {
        $curl = $this->curlFactory->create();
        $curl->setConfig(
            [
                'timeout'   => self::FEED_TIMEOUT,
                'referer'   => $this->urlBuilder->getUrl(),
                'useragent' => $this->productMetadata->getName()
                    . '/' . $this->productMetadata->getVersion()
                    . ' (' . $this->productMetadata->getEdition() . ')',
            ]
        );
        $curl->addOption(CURLOPT_FOLLOWLOCATION, true);
        
        $curl->write(\Zend_Http_Client::GET, $this->getFeedUrl(), '1.0');
        $data = $curl->read();
        $curl->close();
        
        if ($data === false) {
            return false;
        }
        
        $xmlStart = stripos($data, '<?xml');
        if ($xmlStart === false) {
            return false;
        }
        $data = substr($data, $xmlStart);
        $data = trim($data);
        
        try {
            $xml = new \SimpleXMLElement($data);
        } catch (\Exception $e) {
            return false;
        }

        return $xml;
    }

    /**
     * @return string
     */
    public function getFeedUrl()
    {
        if ($this->_feedUrl === null) {
            $this->_feedUrl = $this->_backendConfig->getValue(self::XML_FEED_URL_PATH);
        }

        return $this->_feedUrl;
    }

    /**
     * @return int
     */
    public function getLastUpdate()
    {
        return $this->_cacheManager->load(self::CACHE_KEY_LAST_CHECK);
    }

    /**
     * @return $this
     */
    public function setLastUpdate()
    {
        $this->_cacheManager->save(time(), self::CACHE_KEY_LAST_CHECK);
        return $this;
    }
}
