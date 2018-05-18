<?php
/**
 * @copyright Absolute Commerce Ltd.
 * @license https://abscom.co/terms
 */
namespace Absolute\CacheBust\Controller\Adminhtml\Action;

use Magento\Framework\Controller\Result\Raw;
use Absolute\CacheBust\Controller\Adminhtml\ActionAbstract;

class StaticAction extends ActionAbstract
{
    /**
     * @return Raw
     */
    public function execute()
    {
        try {
            $this->cacheBust->bustStatic();
            $this->messageManager->addSuccessMessage(
                __('Static URLs have been Cache Busted.')
            );
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $this->_redirect('adminhtml/cache/index');
    }
}
