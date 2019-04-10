<?php

namespace imanilchaudhari\CurrencyConverter\Provider;

class YahooApi extends AbstractProvider implements ProviderInterface
{
    /**
     * Url where Curl request is made
     *
     * @var strig
     */
    const API_URL = 'http://download.finance.yahoo.com/d/quotes.csv?s=[fromCurrency][toCurrency]=X&f=nl1d1t1';

    /**
     * {@inheritDoc}
     */
    public function getRate($fromCurrency, $toCurrency)
    {
        $fromCurrency = urlencode($fromCurrency);
        $toCurrency = urlencode($toCurrency);

        $url = str_replace(
            ['[fromCurrency]', '[toCurrency]'],
            [$fromCurrency, $toCurrency],
            static::API_URL
        );

        $rawdata = $this->getPage($url);

        return explode(',', $rawdata)[1];
    }
}
