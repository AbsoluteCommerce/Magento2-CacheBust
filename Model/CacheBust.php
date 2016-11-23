<?php
namespace Absolute\CDNCacheBust\Model;

use Magento\Store\Model\Store;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\ConfigResource\ConfigInterface;
use Magento\Config\Model\ResourceModel\Config\Data\Collection as ConfigCollection;
use Magento\Config\Model\ResourceModel\Config\Data\CollectionFactory as ConfigCollectionFactory;

class CacheBust
{
    const REVISION_PLACEHOLDER = '%rev%';

    const STATIC_UNSECURE_TEMPLATE = 'absolute_cdncachebust/static/unsecure_url';
    const STATIC_SECURE_TEMPLATE   = 'absolute_cdncachebust/static/secure_url';

    const MEDIA_UNSECURE_TEMPLATE = 'absolute_cdncachebust/media/unsecure_url';
    const MEDIA_SECURE_TEMPLATE   = 'absolute_cdncachebust/media/secure_url';

    const UNSECURE_BASE_STATIC_URL = 'web/unsecure/base_static_url';
    const SECURE_BASE_STATIC_URL   = 'web/secure/base_static_url';

    const UNSECURE_BASE_MEDIA_URL = 'web/unsecure/base_media_url';
    const SECURE_BASE_MEDIA_URL   = 'web/secure/base_media_url';

    const SCOPE_DEFAULT = 'default';
    const SCOPE_STORE   = 'stores';
    const SCOPE_WEBSITE = 'websites';

    /** @var ConfigInterface */
    private $config;

    /** @var ScopeConfigInterface */
    private $scopeConfig;

    /** @var ConfigCollectionFactory */
    private $configCollectionFactory;

    /**
     * @param ConfigInterface $config
     * @param ScopeConfigInterface $scopeConfig
     * @param ConfigCollectionFactory $configCollectionFactory
     */
    public function __construct(
        ConfigInterface $config,
        ScopeConfigInterface $scopeConfig,
        ConfigCollectionFactory $configCollectionFactory
    ) {
        $this->config = $config;
        $this->scopeConfig = $scopeConfig;
        $this->configCollectionFactory = $configCollectionFactory;
    }

    /**
     * 
     */
    public function bustAll()
    {
        $this->bustStatic();
        $this->bustMedia();
    }

    /**
     * 
     */
    public function bustStatic()
    {
        $this->_commonLogic(
            self::STATIC_UNSECURE_TEMPLATE,
            self::UNSECURE_BASE_STATIC_URL
        );
        $this->_commonLogic(
            self::STATIC_SECURE_TEMPLATE,
            self::SECURE_BASE_STATIC_URL
        );
    }

    /**
     * 
     */
    public function bustMedia()
    {
        $this->_commonLogic(
            self::MEDIA_UNSECURE_TEMPLATE,
            self::UNSECURE_BASE_MEDIA_URL
        );
        $this->_commonLogic(
            self::MEDIA_SECURE_TEMPLATE,
            self::SECURE_BASE_MEDIA_URL
        );
    }

    /**
     * @param string $templatePath
     * @param string $valuePath
     */
    private function _commonLogic($templatePath, $valuePath)
    {
        /**
         * We are only interested in websites and
         * stores which have a template URL defined.
         */
        $scopesWithTemplate = array_merge(
            $this->_getScopesWithTemplate(
                $templatePath,
                self::SCOPE_DEFAULT
            ),
            $this->_getScopesWithTemplate(
                $templatePath,
                self::SCOPE_WEBSITE
            ),
            $this->_getScopesWithTemplate(
                $templatePath,
                self::SCOPE_STORE
            )
        );

        foreach ($scopesWithTemplate as $_scopeData) {
            /**
             * Generate a new Cache Bust value for this
             * scope, and skip if it fails for any reason.
             */
            $_bustedUrl = $this->_generateUrl($_scopeData['value']);
            if (!$_bustedUrl) {
                continue;
            }

            /**
             * Update the system configuration
             * with the Cache Busted URL value.
             */
            $this->config->saveConfig(
                $valuePath,
                $_bustedUrl,
                $_scopeData['scope'],
                (int)$_scopeData['scope_id']
            );
        }
    }

    /**
     * @param string $path
     * @param string $scope
     * @return array
     */
    private function _getScopesWithTemplate($path, $scope)
    {
        $scopes = [];

        /** @var ConfigCollection $configCollection */
        $configCollection = $this->configCollectionFactory->create();
        $configCollection->addFieldToFilter('path', $path);
        $configCollection->addFieldToFilter('scope', $scope);
        $configCollection->addFieldToFilter('value', ['notnull' => true]);
        
        foreach ($configCollection as $_config) {
            $_value = trim($_config->getValue());
            if (!$_value) {
                continue;
            }
            
            $scopes[] = [
                'path'     => $_config->getPath(),
                'scope'    => $_config->getScope(),
                'scope_id' => $_config->getScopeId(),
                'value'    => $_value,
            ];
        }

        return $scopes;
    }

    /**
     * @param string $template
     * @return bool|string
     */
    protected function _generateUrl($template)
    {
        if (strpos($template, self::REVISION_PLACEHOLDER) === false) {
            return false;
        }

        $revision = date('YmdHis');
        $url = str_replace(self::REVISION_PLACEHOLDER, $revision, $template);
        
        return $url;
    }
}