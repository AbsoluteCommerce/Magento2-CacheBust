<?php
/**
 * @copyright Absolute Commerce Ltd.
 * @license https://abscom.co/terms
 */
namespace Absolute\CacheBust\Controller\Adminhtml\Action;

use Magento\Framework\Controller\Result\Raw;
use Absolute\CacheBust\Controller\Adminhtml\ActionAbstract;

class MediaAction extends ActionAbstract
{
    /**
     * @return Raw
     */
    public function execute()
    {
        try {
            $this->cacheBust->bustMedia();
            $this->messageManager->addSuccessMessage(
                __('Media URLs have been Cache Busted.')
            );
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $this->_redirect('adminhtml/cache/index');
    }
}
