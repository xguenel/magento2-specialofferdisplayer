<?php
declare(strict_types=1);

namespace Dnd\SpecialOfferDisplayer\Model\ResourceModel\Offer;

use Dnd\SpecialOfferDisplayer\Api\Data\OfferInterface;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Dnd\SpecialOfferDisplayer\Model\Offer as OfferModel;
use Dnd\SpecialOfferDisplayer\Model\ResourceModel\Offer as OfferResourceModel;

class Collection extends AbstractCollection
{
    protected $_idFieldName = OfferInterface::ID;
    protected $_eventPrefix = 'offer_collection';
    protected $_eventObject = 'offer_collection';

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(
            OfferModel::class,
            OfferResourceModel::class
        );
    }

    /**
     * Returns pairs offer_id - label
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return $this->_toOptionArray('offer_id', 'offer_label');
    }
}
