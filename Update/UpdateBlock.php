<?php
/**
 * @copyright Absolute Commerce Ltd.
 * @license https://abscom.co/terms
 */
namespace Absolute\CacheBust\Update;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Module\ModuleList\Loader;
use Magento\Framework\Exception\LocalizedException;

class UpdateBlock extends Template implements RendererInterface
{
    const UTM_SOURCE = 'magento2-admin';
    const UTM_MEDIUM = 'block';
    
    /** @var Loader */
    private $loader;
    
    /**
     * @param Context $context
     * @param Loader $loader
     * @param array $data
     */
    public function __construct(
        Context $context,
        Loader $loader,
        array $data = []
    ) {
        parent::__construct($context, $data);
        
        $this->loader = $loader;
    }

    /**
     * @param AbstractElement $element
     * @return string
     * @throws LocalizedException
     */
    public function render(AbstractElement $element)
    {
        $name = $this->getName();
        $version = $this->getVersion();
        $extension = $this->getExtension();
        $logoImageData = $this->getLogoImageData();
        $supportLink = 'https://absolutecommerce.co.uk'
            . '?utm_source=' . self::UTM_SOURCE
            . '&utm_medium=' . self::UTM_MEDIUM
            . '&utm_campaign=' . $extension;
        
        $html = <<<EOF
<div style="border: 1px solid #cccccc; padding: 20px 20px 10px 20px; margin-bottom:10px;">
    <p style="padding-bottom: 10px;"><a href="{$supportLink}" target="_blank"><img width="200px" src="{$logoImageData}"/></a><p>
    <p><strong style="color:#6c2a2a;">{$name} v{$version} from Absolute Commerce</strong></p>
    <p>Need help or custom development? Find us at <strong><a style="color: #6c2a2a;" href="{$supportLink}" target="_blank">https://absolutecommerce.co.uk</a></strong></p>
</div>
EOF;
        
        return $html;
    }

    /**
     * @return string
     */
    private function getName()
    {
        return str_replace('_', ' ', $this->getExtension());
    }

    /**
     * @return string
     */
    private function getExtension()
    {
        $namespaceParts = explode('\\', __NAMESPACE__);
        return $namespaceParts[0] . '_' . $namespaceParts[1];
    }

    /**
     * @return string
     * @throws LocalizedException
     */
    private function getVersion()
    {
        $modules = $this->loader->load();
        $extension = $this->getExtension();
        $version = isset($modules[$extension]['setup_version'])
            ? $modules[$extension]['setup_version']
            : 'Unknown';
        
        return $version;
    }

    /**
     * Base64 string version of the Absolute Commerce logo
     * 
     * @return string
     */
    private function getLogoImageData()
    {
        return 'data:image/png;base64,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';
    }
}
