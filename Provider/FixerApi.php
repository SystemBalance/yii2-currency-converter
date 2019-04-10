<?php

namespace imanilchaudhari\CurrencyConverter\Provider;

use yii\base\Component;

class FixerApi extends AbstractProvider implements ProviderInterface
{
    /**
     * Url where Curl request is made
     *
     * @var string
     */
    const API_URL = 'http://api.fixer.io/latest?base=[fromCurrency]';

    /**
     * @inheritDoc
     */
    public function getRate($fromCurrency, $toCurrency)
    {
        $fromCurrency = urlencode($fromCurrency);
        
        $url = str_replace(['[fromCurrency]'], [$fromCurrency], static::API_URL);

        $rawdata = $this->getPage($url);

        $parsedData = json_decode($rawdata, true);

        return $parsedData['rates'][strtoupper($toCurrency)];
    }
}
