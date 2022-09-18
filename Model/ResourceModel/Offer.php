<?php
declare(strict_types=1);

namespace Dnd\SpecialOfferDisplayer\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Offer extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('dnd_special_offer_displayer', 'offer_id');
    }

    /**
     * Get categories by offer id
     *
     * @param int $offerId
     * @return array
     */
    public function getCategories(int $offerId)
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from('dnd_offermanager_offer_category', 'category_id')
            ->where('offer_id = ?' , $offerId);
        return $this->getConnection()->fetchCol($select);
    }
}
