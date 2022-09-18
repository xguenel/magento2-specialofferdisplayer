<?php
declare(strict_types=1);

namespace Dnd\SpecialOfferDisplayer\Model;

use Dnd\SpecialOfferDisplayer\Api\Data\OfferInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Dnd\SpecialOfferDisplayer\Model\ResourceModel\Offer as OfferResource;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;


class Offer extends AbstractModel implements OfferInterface
{
    public const CACHE_TAG = 'dnd_special_offer_displayer_offer';
    protected $_cacheTag = self::CACHE_TAG;
    private Json $json;

    /**
     * Offer constructor.
     * @param Json $json
     * @param Context $context
     * @param Registry $registry
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Json $json,
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->json = $json;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    protected function _construct(): void
    {
        $this->_init(OfferResource::class);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_getData(self::ID);
    }

    /**
     * @return array
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return string
     */
    public function getOfferLabel(): string
    {
        return $this->_getData(self::OFFER_LABEL);
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->_getData(self::CONTENT);
    }

    /**
     * @return string
     */
    public function getImageFileName(): string
    {
        return $this->_getData(self::IMAGE_FILE_NAME);
    }

    /**
     * @return string
     */
    public function getRedirectionLink(): string
    {
        return $this->_getData(self::REDIRECTION_LINK);
    }

    public function getCategoryList()
    {
        return $this->json->unserialize($this->_getData(self::CATEGORY_LIST));
    }

    /**
     * @return string
     */
    public function getStartingDisplayAt(): string
    {
        return $this->_getData(self::STARTING_DISPLAY_AT);
    }

    /**
     * @return string
     */
    public function getEndingDisplayAt(): string
    {
        return $this->_getData(self::ENDING_DISPLAY_AT);
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->_getData(self::CREATED_AT);
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->_getData(self::UPDATED_AT);
    }

    /**
     * @param $offerLabel
     * @return mixed|null
     */
    public function setOfferLabel($offerLabel)
    {
        return $this->setData(self::OFFER_LABEL, $offerLabel);
    }

    /**
     * @param $content
     * @return mixed|null
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * @param $imageFileName
     * @return mixed|null
     */
    public function setImageFileName($imageFileName)
    {
        return $this->setData(self::IMAGE_FILE_NAME, $imageFileName);
    }

    /**
     * @param $redirectionLink
     * @return mixed|null
     */
    public function setRedirectionLink($redirectionLink)
    {
        return $this->setData(self::REDIRECTION_LINK, $redirectionLink);
    }

    /**
     * @param $categoryList
     * @return mixed|null
     */
    public function setCategoryList($categoryList)
    {
        return $this->setData(self::CATEGORY_LIST, $categoryList);
    }

    /**
     * @param $startingDisplayAt
     * @return mixed|null
     */
    public function setStartingDisplayAt($startingDisplayAt)
    {
        return $this->setData(self::STARTING_DISPLAY_AT, $startingDisplayAt);
    }

    /**
     * @param $endingDisplayAt
     * @return mixed|null
     */
    public function setEndingDisplayAt($endingDisplayAt)
    {
        return $this->setData(self::ENDING_DISPLAY_AT, $endingDisplayAt);
    }
}
