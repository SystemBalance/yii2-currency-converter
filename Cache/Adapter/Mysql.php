<?php

namespace imanilchaudhari\CurrencyConverter\Cache\Adapter;

use imanilchaudhari\CurrencyConverter\Cache\Model\CurrencyRate;
use yii\db\Connection;
use yii\di\Instance;

class Mysql extends AbstractAdapter
{
    /**
     * @var Connection|array|string
     */
    private $db;

    /**
     * Constructor
     *
     * @param Connection|array|string $db
     */
    public function __construct($db = '')
    {
        if(!$db){
            $db = 'db';
        }
        $this->db = Instance::ensure($db, Connection::class);
    }

    /**
     * {@inheritDoc}
     */
    public function cacheExists($fromCurrency, $toCurrency)
    {
        return !$this->isCacheExpired($fromCurrency, $toCurrency);
    }

    /**
     * {@inheritDoc}
     */
    public function createCache($fromCurrency, $toCurrency, $rate)
    {
        $cache = new CurrencyRate([
            'from' => $fromCurrency,
            'to' => $toCurrency,
            'rate' => $rate,
        ]);

        return $cache->save();
    }

    /**
     * {@inheritDoc}
     */
    public function getRate($fromCurrency, $toCurrency)
    {
        return CurrencyRate::find()
            ->select('rate')
            ->where([
                'from' => $fromCurrency,
                'to' => $toCurrency,
            ])
            ->scalar($this->db);
    }

    /**
     * {@inheritDoc}
     */
    protected function getCacheCreationTime($fromCurrency, $toCurrency)
    {
        $timeStamp = CurrencyRate::find()
            ->select('created_at')
            ->where([
                'from' => $fromCurrency,
                'to' => $toCurrency,
            ])
            ->orderBy(['created_at' => SORT_DESC])
            ->scalar($this->db);

        return (int) strtotime($timeStamp);
    }
}
