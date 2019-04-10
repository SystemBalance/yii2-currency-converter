<?php

namespace imanilchaudhari\CurrencyConverter\Provider;

class JsonRatesApi extends AbstractProvider implements ProviderInterface
{
    /**
     * Url where Curl request is made
     *
     * @var string
     */
    const API_URL = 'http://jsonrates.com/get/?from=[fromCurrency]&to=[toCurrency]';

    /**
     * @inheritDoc
     */
    public function getRate($fromCurrency, $toCurrency)
    {
        $fromCurrency = urlencode($fromCurrency);
        
        $url = str_replace(['[fromCurrency]', '[toCurrency]'], [$fromCurrency, $toCurrency], static::API_URL);

        $rawdata = $this->getPage($url);

        $parsedData = json_decode($rawdata, true);

        return $parsedData['rates'][strtoupper($toCurrency)];
    }
}
