<?php

namespace Dnd\SpecialOfferDisplayer\Controller\Adminhtml\Offer;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Catalog\Model\ImageUploader as ImageUploaderModel;
use Magento\Framework\Controller\ResultFactory;

/**
* Class Upload
*/
class ImageUploader extends Action
{
    protected ImageUploaderModel $imageUploader;

    /**
    * @param Context $context
    * @param ImageUploaderModel $imageUploader
    */
    public function __construct(
        Context $context,
        ImageUploaderModel $imageUploader
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }

    /**
    * Upload file controller action
    *
    * @return \Magento\Framework\Controller\ResultInterface
    */
    public function execute()
    {
        $imageId = $this->_request->getParam('param_name', 'image');
        try {
            $result = $this->imageUploader->saveFileToTmpDir($imageId);

        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}
