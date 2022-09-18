<?php
declare(strict_types=1);

namespace Dnd\SpecialOfferDisplayer\Block;

use Dnd\SpecialOfferDisplayer\Api\OfferRepositoryInterface;
use Dnd\SpecialOfferDisplayer\Provider\Config as ConfigProvider;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;


class OfferFrontBlock extends Template
{
    protected ConfigProvider $configProvider;
    protected OfferRepositoryInterface $offerRepository;
    private Resolver $layerResolver;

    public function __construct(
        Template\Context $context,
        ConfigProvider $configProvider,
        OfferRepositoryInterface $offerRepository,
        Resolver $layerResolver,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->configProvider = $configProvider;
        $this->offerRepository = $offerRepository;
        $this->layerResolver = $layerResolver;
    }

    /**
     * @param string|null $storeId
     * @return bool
     */
    public function isSpecialOfferDisplayerEnabled(?string $storeId = null): bool
    {
        return $this->configProvider->isSpecialOfferDisplayerEnabled($storeId);
    }

    /**
     * @param string|null $storeId
     * @return int
     */
    public function getSlidingDelay(?string $storeId = null): int
    {
        return $this->configProvider->getSlidingDelay($storeId);
    }

    /**
     * @param int|null $catId
     * @return \Dnd\SpecialOfferDisplayer\Model\Offer[]
     */
    public function getSpecialOffers(?int $catId = null)
    {
        $catId = $catId ?: $this->getCurrentCategoryId();

        return $this->offerRepository->getOffersByCategoryId($catId, $this->configProvider->getMaxDisplayedOffers());
    }

    /**
     * @return int
     */
    public function getCurrentCategoryId(): int
    {
        return (int)$this->layerResolver->get()->getCurrentCategory()->getId();
    }
}
