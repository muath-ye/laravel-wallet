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
class Wallet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'openning_balance',
        'current_balance',
        'frozen_amount',
        'status',
        'walletable_id',
        'walletable_type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'walletable_id',
        'walletable_type',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    /**
     * Define a one-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function walletTransaction()
    {
        return $this->hasMany(BalanceTransaction::class);
    }

    /**
     * Get the owning walletable model.
     */
    public function walletable()
    {
        return $this->morphTo();
    }
}
