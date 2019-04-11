<?php

namespace imanilchaudhari\CurrencyConverter\Provider;

class RateSxApi extends AbstractProvider implements ProviderInterface
{
    /**
     * Url where Curl request is made
     *
     * @var strig
     */
    const API_URL = 'https://[fromCurrency].rate.sx/1[toCurrency]';

    /**
     * {@inheritDoc}
     */
    public function getRate($fromCurrency, $toCurrency)
    {
        $fromCurrency = urlencode($fromCurrency);
        $toCurrency = urlencode($toCurrency);

        $url = str_replace(
            ['[fromCurrency]', '[toCurrency]'],
            [strtolower($fromCurrency), $toCurrency],
            static::API_URL
        );

        $rate = trim($this->getPage($url));

        return $rate;
    }

}