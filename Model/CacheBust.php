<?php
/**
 * @copyright 2017 Absolute Commerce Ltd. (https://abscom.co/terms)
 */
namespace Absolute\CacheBust\Model;

use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\Value as ConfigValue;
use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\Config\Model\ResourceModel\Config\Data\Collection as ConfigCollection;
use Magento\Config\Model\ResourceModel\Config\Data\CollectionFactory as ConfigCollectionFactory;
use Magento\PageCache\Model\Cache\Type as PageCache;
use Magento\Framework\App\Cache\Type\Config as ConfigCache;
use Magento\Framework\App\Cache\Type\Block as BlockCache;
use Absolute\CacheBust\Model\Config as CacheBustConfig;
use Absolute\CacheBust\Model\Source\YesNo;

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

    /** @var ConfigCollectionFactory */
    private $configCollectionFactory;

    /** @var TypeListInterface */
    private $cacheTypeList;

    /**
     * @param ConfigInterface $config
     * @param ConfigCollectionFactory $configCollectionFactory
     * @param TypeListInterface $cacheTypeList
     */
    public function __construct(
        ConfigInterface $config,
        ConfigCollectionFactory $configCollectionFactory,
        TypeListInterface $cacheTypeList
    ) {
        $this->config = $config;
        $this->configCollectionFactory = $configCollectionFactory;
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
        $this->_updateValues(
            CacheBustConfig::XML_PATH_STATIC_ENABLED,
            CacheBustConfig::XML_PATH_STATIC_VALUE
        );
        
        if ($clearCache) {
            $this->clearCache();
        }
    }

    /**
     * @param bool $clearCache
     */
    public function bustMedia($clearCache = true)
    {
        $this->_updateValues(
            CacheBustConfig::XML_PATH_MEDIA_ENABLED,
            CacheBustConfig::XML_PATH_MEDIA_VALUE
        );

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
     * @param string $enabledPath
     * @param string $valuePath
     */
    private function _updateValues($enabledPath, $valuePath)
    {
        $this->_deleteExistingValues($valuePath);
        
        /** @var ConfigCollection $configCollection */
        $configCollection = $this->configCollectionFactory->create();
        $configCollection->addFieldToFilter('path', $enabledPath);
        $configCollection->addFieldToFilter('value', YesNo::OPTION_YES);
        
        $timestamp = date('YmdHis');
        foreach ($configCollection as $_configValue) {
            /** @var ConfigValue $_configValue */

            $this->config->saveConfig(
                $valuePath,
                $timestamp,
                $_configValue->getScope(),
                (int)$_configValue->getScopeId()
            );
        }
    }

    /**
     * @param string $valuePath
     */
    private function _deleteExistingValues($valuePath)
    {
        /** @var ConfigCollection $configCollection */
        $configCollection = $this->configCollectionFactory->create();
        $configCollection->addFieldToFilter('path', $valuePath);

        foreach ($configCollection as $_configValue) {
            /** @var ConfigValue $_configValue */

            $this->config->deleteConfig(
                $_configValue->getPath(),
                $_configValue->getScope(),
                (int)$_configValue->getScopeId()
            );
        }
    }
}
