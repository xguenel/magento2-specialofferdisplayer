<?php
declare(strict_types=1);

namespace Dnd\SpecialOfferDisplayer\Controller\Adminhtml\Offer;

use Dnd\SpecialOfferDisplayer\Api\OfferRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;


class Edit extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @var string DND_SPECIAL_OFFER_DISPLAYER_EDIT
     */
    public const DND_SPECIAL_OFFER_DISPLAYER_EDIT = 'Dnd_SpecialOfferDisplayer::edit';

    protected PageFactory $resultPageFactory;
    protected OfferRepositoryInterface $offerRepository;

    public function __construct(
        Context $context,
        OfferRepositoryInterface $offerRepository,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);

        $this->offerRepository = $offerRepository;
        $this->resultPageFactory = $resultPageFactory;
    }
    /**
     * @return ResponseInterface|Redirect|ResultInterface|Page
     */
    public function execute()
    {
        $offerData = $this->getRequest()->getParam('offer');

        if(is_array($offerData)) {
            $this->offerRepository->save($offerData);
            $this->_redirect('*/*/index');
        }

        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(Index::DND_SPECIAL_OFFER_DISPLAYER_LISTING);
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Offer'));

        return $resultPage;
    }

    /**
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed(self::DND_SPECIAL_OFFER_DISPLAYER_EDIT);
    }
}
