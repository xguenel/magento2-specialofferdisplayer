<?php
declare(strict_types=1);

namespace Dnd\SpecialOfferDisplayer\Block\Adminhtml\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData(): array
    {
        $data = [];
        if ($this->getId()) {
            return [
                'label' => __('Delete Offer'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\''
                    . __('Are you sure you want to delete this offer?')
                    . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }
        return [];
    }

    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->_urlBuilder->getUrl('*/*/delete', ['id' => $this->getId()]);
    }
}
