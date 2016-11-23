<?php
namespace Absolute\CDNCacheBust\Controller\Adminhtml\Action;

use Magento\Framework\Controller\Result\Raw;
use Absolute\CDNCacheBust\Controller\Adminhtml\ActionAbstract;

class MediaAction extends ActionAbstract
{
    /**
     * @return Raw
     */
    public function execute()
    {
        try {
            $this->cacheBustModel->bustMedia();
            $this->messageManager->addSuccessMessage(
                __('Media CDN Urls have been Cache Busted.')
            );
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $this->_redirect('adminhtml/cache/index');
    }
}
