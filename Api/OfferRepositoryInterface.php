<?php
declare(strict_types=1);

namespace Dnd\SpecialOfferDisplayer\Api;

use Dnd\SpecialOfferDisplayer\Api\Data\OfferInterface;
use Dnd\SpecialOfferDisplayer\Model\Offer;

interface OfferRepositoryInterface
{

    /**
     * @param $offerInterfaceId
     * @return OfferInterface
     */
    public function getById($offerInterfaceId);

    /**
     * @param int $categoryId
     * @param int $maxOfferToDisplay
     * @return Offer[]
     */
    public function getOffersByCategoryId(int $categoryId, int $maxOfferToDisplay = 10);

    /**
     * @param array $offerData
     */
    public function save(array $offerData);

    /**
     * @param OfferInterface $offerInterface
     * @return mixed
     */
    public function delete(OfferInterface $offerInterface);

    /**
     * @param int $offerInterfaceId
     * @return mixed
     */
    public function deleteById(int $offerInterfaceId);
}
