<?php
declare(strict_types=1);

namespace Dnd\SpecialOfferDisplayer\Controller\Adminhtml\Offer;


use Magento\Backend\{
    App\Action,
    App\Action\Context
};
use Magento\Framework\{
    App\Action\HttpPostActionInterface,
    View\Result\PageFactory
};
use Dnd\SpecialOfferDisplayer\Api\Data\OfferInterface;
use Dnd\SpecialOfferDisplayer\Api\OfferRepositoryInterface;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @var string DND_SPECIAL_OFFER_DISPLAYER_SAVE
     */
    public const DND_SPECIAL_OFFER_DISPLAYER_SAVE = 'Dnd_SpecialOfferDisplayer::save';

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
     * @inheritDoc
     */
    public function execute()
    {
        if ($this->getRequest()->getPostValue()) {
            $offerDataPost = $this->getRequest()->getPostValue('offer');
            if ($this->getRequest()->getPostValue('offer')) {
                $this->offerRepository->save($offerDataPost);
            }
        }

        $this->_redirect('*/*/index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed(self::DND_SPECIAL_OFFER_DISPLAYER_SAVE);
    }
}
