<?php

namespace Muathye\Wallet\Support;

/**
 * @method static Wallet enable()
 * @method static Wallet disable()
 * @method static Wallet isEnabled()
 * @method static Wallet Wallet()
 *
 * @see \Muathye\Wallet\Wallet
 */
class Facade extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return Wallet::class;
    }
}
