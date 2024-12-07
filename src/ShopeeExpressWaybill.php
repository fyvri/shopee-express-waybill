<?php

namespace AzisAlvriyanto\ShopeeExpressWaybill;

class ShopeeExpressWaybill
{
    protected $curl;

    public function __construct($curl = null)
    {
        $this->curl = $curl ?? new CurlWrapper();
    }

    public function check(string $shippingNumber): object
    {
        $apiUrl = 'https://spx.co.id/api/v2/fleet_order/tracking/search';
        $currentUnixTime = floor(time());
        $url = $apiUrl . '?sls_tracking_number=' . $shippingNumber . '|' . $currentUnixTime . '' . hash('sha256', $shippingNumber . '' . $currentUnixTime . 'MGViZmZmZTYzZDJhNDgxY2Y1N2ZlN2Q1ZWJkYzlmZDY=');

        $ch = $this->curl->init($url);
        $this->curl->setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $this->curl->setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $this->curl->setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $res = $this->curl->exec($ch);
        if ($this->curl->errno($ch)) {
            $res = [
                'success' => false,
                'message' => $this->curl->error($ch) ?? 'Sorry, looks like there are some errors detected, please try again',
                'data' => null,
            ];
        } else {
            $responseCode = $this->curl->getinfo($ch, CURLINFO_HTTP_CODE);
            if ($responseCode == 200) {
                $res = json_decode($res, true);
                if (isset($res['retcode']) && $res['retcode'] === 0) {
                    $res = [
                        'success' => true,
                        'message' => 'Shipping number found',
                        'data' => $res['data'],
                    ];
                } else {
                    $res = [
                        'success' => false,
                        'message' => 'Shipping number not found',
                        'data' => null,
                    ];
                }
            } else {
                $res = [
                    'success' => false,
                    'message' => 'Failed to retrieve data, HTTP status code: ' . $responseCode,
                    'data' => null,
                ];
            }
        }
        $this->curl->close($ch);

        return (object) $res;
    }
}
