<?php
/**
 * @copyright Absolute Commerce Ltd.
 * @license https://abscom.co/terms
 */
namespace Absolute\CacheBust\Update;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Absolute\CacheBust\Update\UpdateFeed;
use Absolute\CacheBust\Update\UpdateFeedFactory;

class UpdateObserver implements ObserverInterface
{
    /** @var UpdateFeedFactory */
    private $updateFeedFactory;

    /** @var Session */
    private $backendAuthSession;

    /**
     * @param UpdateFeedFactory $updateFeedFactory
     * @param Session $backendAuthSession
     * 
     * @see \Magento\AdminNotification\Observer\PredispatchAdminActionControllerObserver
     */
    public function __construct(
        UpdateFeedFactory $updateFeedFactory,
        Session $backendAuthSession
    ) {
        $this->updateFeedFactory = $updateFeedFactory;
        $this->backendAuthSession = $backendAuthSession;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        if ($this->backendAuthSession->isLoggedIn()) {
            /** @var UpdateFeed $feedModel */
            $feedModel = $this->updateFeedFactory->create();
            $feedModel->checkUpdate();
        }
    }
}
