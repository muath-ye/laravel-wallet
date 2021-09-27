<?php

use Muathye\Wallet\Support\Wallet as SupportWallet;

if (! function_exists('wallet')) {
    /**
     * Returns the Carbon instance
     *
     * @return void
     */
    function wallet()
    {
        SupportWallet::wallet();
    }
}