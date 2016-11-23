<?php
namespace Absolute\CDNCacheBust\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Absolute\CDNCacheBust\Model\CacheBust;

abstract class ActionAbstract extends Action
{
    /** @var CacheBust */
    protected $cacheBustModel;

    /**
     * @param Context $context
     * @param CacheBust $cacheBust
     */
    public function __construct(
        Context $context,
        CacheBust $cacheBust
    ) {
        $this->cacheBustModel = $cacheBust;

        parent::__construct($context);
    }

    /**
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Absolute_CDNCacheBust::action');
    }
}
