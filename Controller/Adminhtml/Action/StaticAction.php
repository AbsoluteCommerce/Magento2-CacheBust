<?php
namespace Absolute\CDNCacheBust\Controller\Adminhtml\Action;

use Magento\Framework\Controller\Result\Raw;
use Absolute\CDNCacheBust\Controller\Adminhtml\ActionAbstract;

class StaticAction extends ActionAbstract
{
    /**
     * @return Raw
     */
    public function execute()
    {
        try {
            $this->cacheBustModel->bustStatic();
            $this->messageManager->addSuccessMessage(
                __('Static CDN Urls have been Cache Busted.')
            );
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $this->_redirect('adminhtml/cache/index');
    }
}
