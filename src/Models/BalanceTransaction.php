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
class BalanceTransaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'transaction_type',
        'note',
        'wallet_id',
        'transactionable_id',
        'transactionable_type',
        'balance_transactionable_id',
        'balance_transactionable_type',
        'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'id',
        // 'note',
        // 'wallet_id',
        // 'balance_transactionable_id',
        // 'balance_transactionable_type',
        // 'transactionable_id',
        // 'transactionable_type',
    ];

    /**
     * Get the owning balanceTransactionable model.
     */
    public function balanceTransactionable()
    {
        return $this->morphToMany(
            BalanceTransaction::class,
            'balance_transactionable'
        );
    }

    /**
     * Get the service's, request's or so on transactionable model.
     */
    public function transactionable()
    {
        return $this->morphToMany(
            BalanceTransaction::class,
            'transactionable'
        );
    }
}
