<?php
/**
 * @copyright Absolute Commerce Ltd.
 * @license https://abscom.co/terms
 */
namespace Absolute\CacheBust\Model;

use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\PageCache\Model\Cache\Type as PageCache;
use Magento\Framework\App\Cache\Type\Config as ConfigCache;
use Magento\Framework\App\Cache\Type\Block as BlockCache;
use Absolute\CacheBust\Model\Config as CacheBustConfig;

class CacheBust
{
    /** @var array */
    private $cacheTypes = [
        ConfigCache::TYPE_IDENTIFIER,
        BlockCache::TYPE_IDENTIFIER,
        PageCache::TYPE_IDENTIFIER,
    ];
    
    /** @var ConfigInterface */
    private $config;

    /** @var TypeListInterface */
    private $cacheTypeList;

    /**
     * @param ConfigInterface $config
     * @param TypeListInterface $cacheTypeList
     */
    public function __construct(
        ConfigInterface $config,
        TypeListInterface $cacheTypeList
    ) {
        $this->config = $config;
        $this->cacheTypeList = $cacheTypeList;
    }

    /**
     *
     */
    public function bustAll()
    {
        $this->bustStatic(false);
        $this->bustMedia(false);
        
        $this->clearCache();
    }

    /**
     * @param bool $clearCache
     */
    public function bustStatic($clearCache = true)
    {
        $this->updateValue(CacheBustConfig::XML_PATH_STATIC_VALUE);
        
        if ($clearCache) {
            $this->clearCache();
        }
    }

    /**
     * @param bool $clearCache
     */
    public function bustMedia($clearCache = true)
    {
        $this->updateValue(CacheBustConfig::XML_PATH_MEDIA_VALUE);

        if ($clearCache) {
            $this->clearCache();
        }
    }

    /**
     *
     */
    public function clearCache()
    {
        foreach ($this->cacheTypes as $_type) {
            $this->cacheTypeList->cleanType($_type);
        }
    }

    /**
     * @param string $valuePath
     */
    private function updateValue($valuePath)
    {
        $this->config->saveConfig(
            $valuePath,
            date('YmdHis'),
            'default',
            0
        );
    }
}
