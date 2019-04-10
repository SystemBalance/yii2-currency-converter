<?php

namespace imanilchaudhari\CurrencyConverter\Provider;

class RCBApi extends AbstractProvider implements ProviderInterface
{
    /**
     * @var array
     */
    private $allCurrency    = [];
    /**
     * @var string
     */
    private $filter         = '';
    /**
     * @var array
     */
    private $filterCurrency = [];

    /**
     * Url where Curl request is made
     *
     * @var strig
     */
    const API_URL = 'https://www.cbr-xml-daily.ru/daily_json.js';

    /**
     * {@inheritDoc}
     */
    public function getRate($fromCurrency, $toCurrency)
    {
        $fromCurrency = urlencode($fromCurrency);
        $toCurrency = urlencode($toCurrency);

        $this->filter(['date' => time()-(86400*7), 'currency' => $toCurrency]);

        $url = static::API_URL . "?1=1" . $this->filter;

        $rawdata = $this->getPage($url);

        $parsedData = json_decode($rawdata, true);

        if(isset($parsedData["Valute"]) && isset($parsedData["Valute"]["EUR"]) && isset($parsedData["Valute"][$toCurrency]["Value"])){
            return $parsedData["Valute"][$toCurrency]["Value"];
        }

        return 1;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function filter(array $params)
    {
        $this->filter = '';

        $params = array_merge([
            'date' => '',
            'currency' => '',
        ], $params);
        if ($params['date']) {
            if (!is_numeric($params['date'])) {
                $params['date'] = strtotime($params['date']);
            }
            $this->filter .= "&date_req=".date("d/m/Y", $params['date']);
        }

        return $this;
    }
}
