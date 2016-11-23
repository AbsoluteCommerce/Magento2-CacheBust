<?php
namespace Absolute\CDNCacheBust\Controller\Adminhtml\Action;

use Magento\Framework\Controller\Result\Raw;
use Absolute\CDNCacheBust\Controller\Adminhtml\ActionAbstract;

class AllAction extends ActionAbstract
{
    /**
     * @return Raw
     */
    public function execute()
    {
        try {
            $this->cacheBustModel->bustAll();
            $this->messageManager->addSuccessMessage(
                __('All CDN Urls have been Cache Busted.')
            );
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $this->_redirect('adminhtml/cache/index');
    }
}
