<?php

namespace Muathye\Wallet\Support;

/**
 * @method static Wallet deposit()
 *
 * @see \Muathye\Wallet\Wallet
 */
class Wallet extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'wallet';
    }
}
