<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        $this->configure();
    }

    public function configure()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function getSnapToken($params)
    {
        $this->configure();
        return Snap::getSnapToken($params);
    }
    
    public function getSnapUrl($params) 
    {
        $this->configure();
        // createTransaction returns object with redirect_url
        $transaction = Snap::createTransaction($params);
        return $transaction->redirect_url;
    }
}
