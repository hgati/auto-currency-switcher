<?php

namespace Hgati\AutoCurrencySwitcher\Plugin;

use Hgati\AutoCurrencySwitcher\Helper\Data;
use Magento\Directory\Model\Currency;
use Magento\Store\Model\StoreManagerInterface;

class FrontControllerInterface
{
    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var Currency
     */
    protected $currency;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    public function __construct(
        Data $helper,
        Currency $currency,
        StoreManagerInterface $storeManager
    )
    {
        $this->helper = $helper;
        $this->currency = $currency;
        $this->storeManager = $storeManager;
    }

    /**
     * Update current store currency code
     *
     * @param \Magento\Framework\App\FrontControllerInterface $subject
     * @param callable $proceed
     * @param \Magento\Framework\App\RequestInterface $request
     *
     * @return \Magento\Framework\Controller\ResultInterface|\Magento\Framework\App\Response\Http
     */
    public function aroundDispatch(
        \Magento\Framework\App\FrontControllerInterface $subject,
        \Closure $proceed,
        \Magento\Framework\App\RequestInterface $request
    ) {
        if ($this->helper->isEnabled()) {
            $currentCurrency = $this->storeManager->getStore()->getCurrentCurrencyCode();
            $newCurrency = $this->getCurrencyCodeByIp($currentCurrency);
            if ($currentCurrency !== $newCurrency) {
                $this->storeManager->getStore()->setCurrentCurrencyCode($newCurrency);
                unset($_COOKIE[\Magento\Framework\App\Response\Http::COOKIE_VARY_STRING]);
            }
        }
        return $proceed($request);
    }

    /**
     * Get Currency code by IP Address
     *
     * @param string $result Currency Code
     * @return string $currencyCode
     */
    public function getCurrencyCodeByIp($result = '')
    {
        $currencyCode = $this->getCurrencyCodeIp2Country($result);
        // if currencyCode is not present in allowedCurrencies
        // then return the default currency code
        $allowedCurrencies = $this->currency->getConfigAllowCurrencies();
        //$allowedCurrencies = $this->currencyFactory->getConfigAllowCurrencies();
        if (!in_array($currencyCode, $allowedCurrencies)) {
            return $result;
        }
        return $currencyCode;
    }

    /**
     * Get Currency code
     * Using GeoIP2 Nginx FastCGI Env Var
     *
     * @param string $result Currency Code
     * @return string $currencyCode
     */
    public function getCurrencyCodeIp2Country($result = '')
    {
        $countryCode = getenv('GEOIP_COUNTRY_CODE');
        $currencyCode = $this->helper->getCurrencyByCountry($countryCode);
        return $currencyCode;
    }
}
