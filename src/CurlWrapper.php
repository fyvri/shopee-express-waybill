<?php

namespace AzisAlvriyanto\ShopeeExpressWaybill;

class CurlWrapper
{
    public function init($url)
    {
        return curl_init($url);
    }

    public function setopt($ch, $option, $value)
    {
        return curl_setopt($ch, $option, $value);
    }

    public function exec($ch)
    {
        return curl_exec($ch);
    }

    public function errno($ch)
    {
        return curl_errno($ch);
    }

    public function error($ch)
    {
        return curl_error($ch);
    }

    public function getinfo($ch, $option)
    {
        return curl_getinfo($ch, $option);
    }

    public function close($ch)
    {
        return curl_close($ch);
    }
}
