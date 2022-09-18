<?php
declare(strict_types=1);

namespace Dnd\SpecialOfferDisplayer\Provider;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    public const XML_PATH_DND_SPECIAL_OFFER_DISPLAYER_CONFIGURATION_ENABLED =
                                                        'dnd_special_offer_displayer/configuration/enabled';
    public const XML_PATH_DND_SPECIAL_OFFER_DISPLAYER_CONFIGURATION_MAX_OFFER_DISPLAYED =
                                                        'dnd_special_offer_displayer/configuration/max_offer_displayed';
    public const XML_PATH_DND_SPECIAL_OFFER_DISPLAYER_CONFIGURATION_SLIDING_DELAY =
                                                        'dnd_special_offer_displayer/configuration/sliding_delay';

    protected ScopeConfigInterface $scopeConfig;

    /**
     * Config constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param string|null $storeId
     * @return bool
     */
    public function isSpecialOfferDisplayerEnabled(?string $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_DND_SPECIAL_OFFER_DISPLAYER_CONFIGURATION_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param string|null $storeId
     * @return int
     */
    public function getMaxDisplayedOffers(?string $storeId = null): int
    {
        return (int) $this->scopeConfig->getValue(
            self::XML_PATH_DND_SPECIAL_OFFER_DISPLAYER_CONFIGURATION_MAX_OFFER_DISPLAYED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @param string|null $storeId
     * @return int
     */
    public function getSlidingDelay(?string $storeId = null): int
    {
        return (int) $this->scopeConfig->getValue(
            self::XML_PATH_DND_SPECIAL_OFFER_DISPLAYER_CONFIGURATION_SLIDING_DELAY,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
