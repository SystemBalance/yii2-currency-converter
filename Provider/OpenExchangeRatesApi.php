<?php

namespace imanilchaudhari\CurrencyConverter\Provider;

class OpenExchangeRatesApi extends AbstractProvider implements ProviderInterface
{
    /**
     * Url where Curl request is made
     *
     * @var string
     */
    const API_URL = 'https://openexchangerates.org/api/latest.json?app_id=[appId]&base=[fromCurrency]';

    /**
     * The Open Exchange Rate APP ID
     *
     * @var string
     */
    public $appId;

    /**
     * {@inheritDoc}
     */
    public function getRate($fromCurrency, $toCurrency)
    {
        $fromCurrency = urlencode($fromCurrency);

        $url = str_replace(
            ['[fromCurrency]', '[appId]'],
            [$fromCurrency, $this->appId],
            static::API_URL
        );

        $rawdata = $this->getPage($url);

        $parsedData = json_decode($rawdata, true);

        return $parsedData['rates'][strtoupper($toCurrency)];
    }
}
