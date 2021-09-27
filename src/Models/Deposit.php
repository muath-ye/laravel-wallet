<?php
/**
 * Models
 * php version 7.2.
 *
 * @category Package
 * @package  LaravelWallet
 * @author   BySwadi <muath.ye@gmail.com>
 * @license  Muathye https://muath-ye.github.io
 * @link     LaravelWallet https://www.github.com/muath-ye/laravel-wallet
 */

namespace Muathye\Wallet\Models;

use Muathye\Wallet\Traits\HasTransaction;
use Illuminate\Database\Eloquent\Model;

/**
 * Models
 * php version 7.2.
 *
 * @category Package
 * @package  LaravelWallet
 * @author   BySwadi <muath.ye@gmail.com>
 * @license  Muathye https://muath-ye.github.io
 * @link     LaravelWallet https://www.github.com/muath-ye/laravel-wallet
 */
class Deposit extends Model
{
    use HasTransaction;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'wallet_id',
        'dispositable_id',
        'dispositable_type',
        'note'
    ];

    /**
     * Get the owning dispositable model.
     */
    public function dispositable()
    {
        return $this->morphToMany(
            Deposit::class,
            'dispositable'
        );
    }
}
