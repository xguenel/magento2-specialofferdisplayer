<?php
declare(strict_types=1);

namespace Dnd\SpecialOfferDisplayer\Controller\Adminhtml\Offer;

use Dnd\SpecialOfferDisplayer\Api\OfferRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;

class Delete extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @var string DND_SPECIAL_OFFER_DISPLAYER_DELETE
     */

    const DND_SPECIAL_OFFER_DISPLAYER_DELETE = 'Dnd_SpecialOfferDisplayer::delete';
    private OfferRepositoryInterface $offerRepository;

    /**
     * Delete constructor.
     * @param OfferRepositoryInterface $offerRepository
     * @param Context $context
     */
    public function __construct(
        OfferRepositoryInterface $offerRepository,
        Context $context
    ) {
        $this->offerRepository = $offerRepository;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $offerId = $this->getRequest()->getParam('id');
        $this->offerRepository->deleteById($offerId);

        return $this->resultRedirectFactory->create()->setPath('*/*/index');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(self::DND_SPECIAL_OFFER_DISPLAYER_DELETE);
    }
}
