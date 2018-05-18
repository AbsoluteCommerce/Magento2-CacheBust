<?php
/**
 * @copyright Absolute Commerce Ltd.
 * @license https://abscom.co/terms
 */
namespace Absolute\CacheBust\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Absolute\CacheBust\Model\CacheBust;

abstract class ActionAbstract extends Action
{
    /** @var CacheBust */
    protected $cacheBust;

    /**
     * @param Context $context
     * @param CacheBust $cacheBust
     */
    public function __construct(
        Context $context,
        CacheBust $cacheBust
    ) {
        $this->cacheBust = $cacheBust;

        parent::__construct($context);
    }

    /**
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Absolute_CacheBust::action');
    }
}
