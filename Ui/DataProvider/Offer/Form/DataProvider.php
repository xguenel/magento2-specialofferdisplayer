<?php

namespace Dnd\SpecialOfferDisplayer\Ui\DataProvider\Offer\Form;

use Dnd\SpecialOfferDisplayer\Model\ResourceModel\Offer as OfferResource;
use Dnd\SpecialOfferDisplayer\Model\ResourceModel\Offer\CollectionFactory as OfferCollectionFactory;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    private string $mediaUrl;
    private OfferResource $offerResource;

    /**
     * DataProvider constructor.
     * @param OfferResource             $offerResource
     * @param OfferCollectionFactory    $offerCollectionFactory
     * @param StoreManagerInterface     $storeManager
     * @param Json                      $json
     * @param string                    $name
     * @param string                    $primaryFieldName
     * @param string                    $requestFieldName
     * @param array                     $meta
     * @param array                     $data
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function __construct(
        OfferResource           $offerResource,
        OfferCollectionFactory  $offerCollectionFactory,
        StoreManagerInterface   $storeManager,
        Json                    $json,
        string                  $name,
        string                  $primaryFieldName,
        string                  $requestFieldName,
        array                   $meta = [],
        array                   $data = []
    ) {
        $this->offerResource = $offerResource;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->collection   = $offerCollectionFactory->create();
        $this->mediaUrl     = $storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $this->loadedData = [];
        foreach ($items as $offer) {
            $this->loadedData[$offer->getId()]['offer'] = $offer->getData();
            $categoryList = $offer->getCategoryList();
            foreach ($categoryList as $category) {
                $this->loadedData[$offer->getId()]['offer']['categories'][] = $category;
            }
            $this->loadedData[$offer->getId()]['offer']['image'][0]['name'] = $offer->getImageFileName();
            $this->loadedData[$offer->getId()]['offer']['image'][0]['url'] = $offer->getImageFileName();
        }

        return $this->loadedData;
    }
}
