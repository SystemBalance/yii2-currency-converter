<?php

namespace imanilchaudhari\CurrencyConverter\Cache\Adapter;

use DateInterval;
use imanilchaudhari\CurrencyConverter\Exception\InvalidArgumentException;

abstract class AbstractAdapter implements CacheAdapterInterface
{

    /**
     * Interval of cache life
     *
     * @var DateInterval
     */
    protected $cacheTimeout;

    /**
     * Sets cache timeout
     *
     * @param DateInterval $cacheTimeout
     * @return self
     */
    public function setCacheTimeOut(DateInterval $cacheTimeout)
    {
        $this->cacheTimeout = $cacheTimeout;

        return $this;
    }

    /**
     * Gets cache timeout
     *
     * @return DateInterval
     */
    public function getCacheTimeOut()
    {
        if (!$this->cacheTimeout) {
            $this->setCacheTimeOut(DateInterval::createFromDateString('+5 hours'));
        }

        return $this->cacheTimeout;
    }

    /**
     * Checks if cache is expired
     *
     * @param  string $fromCurrency
     * @param  string $toCurrency
     * @return bool
     */
    protected function isCacheExpired($fromCurrency, $toCurrency)
    {
        $cacheCreationTime = $this->getCacheCreationTime($fromCurrency, $toCurrency);

        $interval = $this->getCacheTimeOut();

        $seconds = $interval->days*86400 + $interval->h*3600
        + $interval->i*60 + $interval->s;

        return (time() - $cacheCreationTime) > $seconds;
    }

    /**
     * {@inheritDoc}
     */
    public function cacheExists($fromCurrency, $toCurrency)
    {
        return !$this->isCacheExpired($fromCurrency, $toCurrency);
    }

    /**
     * Returns timestamp in which cache was created
     *
     * @param  string $fromCurrency
     * @param  string $toCurrency
     * @return int
     */
    abstract protected function getCacheCreationTime($fromCurrency, $toCurrency);

}
