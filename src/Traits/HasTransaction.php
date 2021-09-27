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

use Muathye\Wallet\Models\BalanceTransaction;
use Muathye\Wallet\Models\Deposit;
use Muathye\Wallet\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Muathye\Wallet\Exceptions\WalletException;

trait HasTransaction
{
    /**
     * Get the user's balanceTransactions.
     */
    public function balanceTransaction()
    {
        return $this->morphMany(
            BalanceTransaction::class,
            'balance_transactionable',
            'balance_transactionable_type',
            'balance_transactionable_id',
            'id'
        );
    }

    /**
     * Get the service's, request's or so on transactions.
     */
    public function transaction()
    {
        return $this->morphMany(
            BalanceTransaction::class,
            'transactionable',
            'transactionable_type',
            'transactionable_id',
            'id'
        );
    }

    /**
     * Add to balance
     *
     * @param float                              $amount            money
     * @param Illuminate\Database\Eloquent\Model $dispositable_type
     * Full Model name of Disposter like (App\Models\Admin::class or App\Models\Points::class). مدين
     * @param string $note              .
     *
     * @return int
     */
    public function addToBalance(
        $amount,
        $dispositable_type,
        $note = null
    ) {
        // TODO: user DB::transaction
        // ^ get amount from method param
        // ^ get object from method param
        // * create new Transaction object with passed amount
        // ^ get current model name
        // ^ save transaction object to model by using transaction relation
        $data = array();
        $wallet_id = $this->getModel()->wallet->id; // دائن
        $dispositable_id = $dispositable_type->id; // مدين

        DB::transaction(
            function () use (
                $amount,
                $wallet_id,
                $dispositable_id,
                $dispositable_type,
                $note,
                &$data
            ) {
                $price_amount = $amount;

                // add to deposit
                Deposit::create([
                    'amount' => $price_amount,
                    'wallet_id' => $wallet_id,
                    'dispositable_id' => $dispositable_id,
                    'dispositable_type' => get_class($dispositable_type),
                    'note' => $note
                ]);

                // get new wallet data
                $model = Wallet::find($wallet_id)->walletable;
                
                $balance = new BalanceTransaction([
                    'amount' => $price_amount,
                    'transaction_type' => 'add',
                    'wallet_id' => $wallet_id,
                    'note' => $note,
                    // دائن
                    'transactionable_id' => $model->id,
                    'transactionable_type' => get_class($model),
                    // مدين
                    'balance_transactionable_id' => $dispositable_id,
                    'balance_transactionable_type' => $dispositable_type,
                ]);

                // Check if wallet is active
                if ($model->wallet->status == 0) {
                    throw new WalletException(
                        ['Invalid wallet'],
                        'The specified ' . class_basename($model) . ' wallet is not activated.'
                    );
                }

                // insert balance transaction data for selected user
                $data = $dispositable_type->balanceTransaction()->save($balance);

                // update wallet for that use
                // get new wallet data
                $walletModel = $model;

                // insert wallet data for selected user
                $wallet = $walletModel->wallet()->update([
                    'current_balance' =>  $model->wallet->current_balance + $price_amount
                ]);

                $data = $wallet;
            }
        );

        return $data;
    }

    /**
     * Subtract from balance
     *
     * @param  int  $amount  money
     * @param Illuminate\Database\Eloquent\Model $service
     * Full Model name of class like (App\Models\Service::class). مدين
     * @param  Illuminate\Database\Eloquent\Model  $service  like request, advertisement or so on
     *
     * @return int
     */
    public function subFromBalance(
        $amount,
        $service,
        $note = null
    ) {
        // ^ get amount from method param
        // ^ get object from method param
        // * create new Transaction object with passed amount
        // ^ get current model name
        // ^ save transaction object to model by using transaction relation

        $data = array();
        $wallet_id = $this->getModel()->wallet->id; // دائن

        DB::transaction(function () use (
            $amount,
            $wallet_id,
            $service,
            $note,
            &$data
        ) {

            $price_amount = $amount;

            $service = $service;
            $serviceId = $service->id;
            $serviceModel = $service->getModel();

            // get user|branch|so on data
            $model = $this->getModel();

            // get new wallet data
            $balance = new BalanceTransaction([
                'amount' => $price_amount,
                'transaction_type' => 'subtract',
                'wallet_id' => $wallet_id,
                'note' => $note,
                // دائن
                'transactionable_id' => $model->id,
                'transactionable_type' => get_class($model),
                // مدين
                'balance_transactionable_id' => $serviceId,
                'balance_transactionable_type' => get_class($serviceModel),
            ]);

            // Check if wallet is active
            if ($model->wallet->status == 0) {
                throw new WalletException(
                    ['Invalid wallet'],
                    'The specified ' . class_basename($model) . ' wallet is not activated.'
                );
            }

            // validate prices
            if (($model->wallet->current_balance - $price_amount) < 0) {
                throw new WalletException(
                    ['Invalid wallet'],
                    'The specified ' . class_basename($model) . ' wallet credit is not enough.'
                );
            }

            // insert balance transaction data for selected user
            $data = $model->balanceTransaction()->save($balance);

            // update wallet for that use
            // get new wallet data
            $walletModel = $model;

            // insert wallet data for selected user
            $data = $walletModel->wallet()->update([
                'current_balance' => $model->wallet->current_balance - $price_amount
            ]);
        });

        return $data;
    }
}
