<?php
declare(strict_types=1);

namespace Dnd\SpecialOfferDisplayer\Model;

use Dnd\SpecialOfferDisplayer\Api\Data\OfferInterface;
use Dnd\SpecialOfferDisplayer\Api\OfferRepositoryInterface;
use Dnd\SpecialOfferDisplayer\Model\OfferFactory as OfferModelFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class OfferRepository
 * @package Dnd\SpecialOfferDisplayer\Model
 */
class OfferRepository implements OfferRepositoryInterface
{
    protected OfferInterface            $offerModel;
    protected ResourceModel\Offer       $offerResource;
    protected OfferFactory              $offerModelFactory;
    protected StoreManagerInterface     $storeManager;
    private   ImageUploader             $imageUploader;
    private   Json                      $json;

    /**
     * OfferRepository constructor.
     * @param OfferInterface            $offerModel
     * @param ResourceModel\Offer       $offerResource
     * @param OfferFactory              $offerModelFactory
     * @param StoreManagerInterface     $storeManager
     * @param ImageUploader             $imageUploader
     * @param Json                      $json
     */
    function __construct(
        OfferInterface                  $offerModel,
        ResourceModel\Offer             $offerResource,
        OfferFactory                    $offerModelFactory,
        StoreManagerInterface           $storeManager,
        ImageUploader                   $imageUploader,
        Json                            $json
    ) {
        $this->offerModel             = $offerModel;
        $this->offerResource          = $offerResource;
        $this->offerModelFactory      = $offerModelFactory;
        $this->storeManager           = $storeManager;
        $this->imageUploader          = $imageUploader;
        $this->json                   = $json;
    }

    /**
     * @inheritDoc
     */
    public function save(array $offerData)
    {
        if ($offerData['offer_id'] === '') {
            unset($offerData['offer_id']);
        }

        $offerData['category_list'] = $this->json->serialize($offerData['categories']);
        unset($offerData['categories']);

        try {
            $this->offerModel->addData($offerData);

            $imageData = $offerData['image'];
            if (isset($imageData[0]['tmp_name'])
                && isset($imageData[0]['name'])
            ) {
                $imageName = $imageData[0]['name'];
                $imagePath = $this->imageUploader->moveFileFromTmp($imageName);
                $this->offerModel->addData([
                    'image_file_name' =>
                        $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . "/" .
                        $this->imageUploader->getBasePath() . "/" . $imagePath,
                ]);
            }

            $this->offerResource->save($this->offerModel);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }

        return $offerData;
    }

    /**
     * @inheritDoc
     */
    public function getById($offerInterfaceId)
    {
        $offer = $this->offerModelFactory->create();
        $this->offerResource->load($offer, $offerInterfaceId);
        if (!$offer->getId()) {
            throw new NoSuchEntityException(__('Offer id "%1" does not exist', $offerInterfaceId));
        }
        return $offer;
    }

    /**
     * @inheritDoc
     */
    public function delete($offerInterface)
    {
        try {
            $this->offerResource->delete($offerInterface);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }

        return $offerInterface;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($offerInterfaceId)
    {
        return $this->delete($this->getById($offerInterfaceId));
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @param int $categoryId
     * @return Offer[]
     */
    public function getOffersByCategoryId(?int $categoryId, int $maxOfferToDisplay = 10)
    {
        if (!$categoryId) {
            return [];
        }

        if ($maxOfferToDisplay === 0) {
            $maxOfferToDisplay = 10;
        }
        $today = date('Y-m-d');

        $offers = [];
        $connection = $this->offerResource->getConnection();
        $offerIds = $connection->select()
            ->from('dnd_special_offer_displayer', ['offer_id', 'category_list'])
            ->where('starting_display_at <= "' . $today . '"')
            ->where('ending_display_at >= "' . $today . '"')
            ->where('category_list like "%' . $categoryId . '%"')
            ->order('updated_at DESC')
        ;

        $offerIds = $connection->fetchAll($offerIds);

        $offerDisplayed = 0;
        foreach ($offerIds as $offerId) {
            if (!$this->isOfferOnCategory($categoryId, $offerId['category_list'])) {
                continue;
            }

            $offer = $this->offerModelFactory->create();
            $this->offerResource->load($offer, $offerId['offer_id']);
            $offers[] = $offer;

            if (++$offerDisplayed >= $maxOfferToDisplay) {
                break;
            }
        }

        return $offers;
    }

    private function isOfferOnCategory(int $categoryId, string $category_list)
    {
        $categoryIds = $this->json->unserialize($category_list);
        return in_array($categoryId, $categoryIds);
    }
}

