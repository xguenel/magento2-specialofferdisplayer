<?php
declare(strict_types=1);

namespace Dnd\SpecialOfferDisplayer\Controller\Adminhtml\Offer;

use Magento\Backend\{
    App\Action,
    App\Action\Context
};
use Magento\Framework\{
    App\Action\HttpGetActionInterface,
    View\Result\Page,
    View\Result\PageFactory
};

/**
 * Class Index
 *
 * @package   Dnd\SpecialOfferDisplayer\Controller\Adminhtml\Offer
 * @author    X
 * @copyright 1979 - present
 * @license   See LICENSE bundled with this library for license details.
 * @link      https://www.a-link-to-the-past.fr/
 */
class Index extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @var string DND_SPECIAL_OFFER_DISPLAYER_LISTING
     */
    public const DND_SPECIAL_OFFER_DISPLAYER_LISTING = 'Dnd_SpecialOfferDisplayer::listing';

    protected PageFactory $resultPageFactory;

    /**
     * Index constructor
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);

        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return Page
     */
    public function execute(): Page
    {
        /** @var Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(self::DND_SPECIAL_OFFER_DISPLAYER_LISTING);
        $resultPage->getConfig()->getTitle()->prepend(__('Offers Setting Index'));

        return $resultPage;
    }

    /**
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed(self::DND_SPECIAL_OFFER_DISPLAYER_LISTING);
    }
}

