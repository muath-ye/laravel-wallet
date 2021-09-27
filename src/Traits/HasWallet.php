<?php
/**
 * Traits
 * php version 7.2.
 *
 * @category Package
 * @package  LaravelWallet
 * @author   BySwadi <muath.ye@gmail.com>
 * @license  Muathye https://muath-ye.github.io
 * @link     LaravelWallet https://www.github.com/muath-ye/laravel-wallet
 */
namespace Muathye\Wallet\Traits;

use Illuminate\Support\Facades\DB;
use Muathye\Wallet\Exceptions\WalletException;
use Muathye\Wallet\Models\BalanceTransaction;
use Muathye\Wallet\Models\Deposit;
use Muathye\Wallet\Models\Wallet;
use Muathye\Wallet\Traits\HasTransaction;

trait HasWallet
{
    use HasTransaction;

    /**
     * Get the user's wallet.
     */
    public function wallet()
    {
        return $this->morphOne(Wallet::class, 'walletable');
    }

    /**
     * Open balance
     * TODO: =>Test : App\Models\User::first()->openWallet(64)
     *
     * @param int|null $opening_balance price amount
     *
     * @return int
     */
    public function openWallet($depositer, $opening_balance = null)
    {
        $data = array();

        DB::transaction(function () use ($opening_balance, $depositer, &$data) {

            $price_amount = $opening_balance ?? config('wallet.opening-balance') ?? 0;
            
            // get new wallet data
            $wallet = new Wallet([
                'current_balance' =>  $price_amount,
                'openning_balance' =>  $price_amount
            ]);

            // get user|branch|so on data
            $model = $this->getModel();

            // check if current model already has wallet
            if (! is_null($model->wallet()->first())) {
                throw new WalletException(
                    ['Invalid wallet'],
                    'The specified ' . class_basename($model) . ' already has a wallet.'
                );
            }

            // insert wallet data for selected user
            $wallet = $model->wallet()->save($wallet);

            /** insert new balance_transaction */
            // add to deposit
            Deposit::create([
                'amount' => $price_amount,
                'wallet_id' => $wallet->id,
                'dispositable_id' => $depositer->id,
                'dispositable_type' => get_class($depositer),
                'note' => 'Opening new wallet'
            ]);

            // ddd(get_class($model), get_class($depositer));
            // get new wallet data
            $balance = new BalanceTransaction([
                'amount' => $price_amount,
                'transaction_type' => 'add',
                'wallet_id' => $wallet->id,
                // دائن
                'transactionable_id' => $model->id,
                'transactionable_type' => get_class($model),
                // مدين
                'balance_transactionable_id' => $depositer->id,
                'balance_transactionable_type' => get_class($depositer),
            ]);

            // insert balance transaction data for selected user
            $data = $model->balanceTransaction()->save($balance);

            $data = $wallet;
        });

        return collect($data);
    }
}