<?php

namespace imanilchaudhari\CurrencyConverter\Provider;

use yii\base\Component;

class CurrencylayerApi extends AbstractProvider implements ProviderInterface
{
    /**
     * Url where Curl request is made
     *
     * @var string
     */
    const API_URL = 'http://www.apilayer.net/api/live?access_key=49af376f2fc6c1312fa58d695df5a026&source=USD&curriences=GBP&format=1';

    /**
     * The Api Layer access_key
     *
     * @var string
     */
    public $access_key;

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
