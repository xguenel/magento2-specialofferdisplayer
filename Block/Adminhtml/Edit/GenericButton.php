<?php
declare(strict_types=1);

namespace Dnd\SpecialOfferDisplayer\Block\Adminhtml\Edit;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;

class GenericButton
{
    /**
     * @var RequestInterface
     */
    private RequestInterface $_request;
    /**
     * @var UrlInterface
     */
    public UrlInterface $_urlBuilder;

    public function __construct(
        RequestInterface $request,
        \Magento\Backend\Block\Widget\Context $context
    ) {
        $this->_request = $request;
        $this->_urlBuilder = $context->getUrlBuilder();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_request->getParam('id');
    }

}
