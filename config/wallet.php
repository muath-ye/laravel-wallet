<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Wallet settings
     |--------------------------------------------------------------------------
     |
     | Wallet settings should be configured before first inster into the
     | database, because of relationships between tables.
     |
     */

    /*
    |--------------------------------------------------------------------------
    | The amount of opening balance
    |--------------------------------------------------------------------------
    | The amount for the user should be zero.
    |
    */
    'opening-balance' => env('OPENING_BALANCE', 0),
    
    /*
    |--------------------------------------------------------------------------
    | Wallet Polymorphic Types
    |--------------------------------------------------------------------------
    |
    | By default, Laravel will use the fully qualified class name to store the
    | type of the related model. For instance, given the one-to-many example
    | above where a Comment may belong to a Post or a Video, the default
    | commentable_type would be either App\Post or App\Video, respectively.
    | However, you may wish to decouple your database from your application's
    | internal structure. In that case, you may define a "wallet morph map"
    | to instruct Eloquent to use a custom name for each model.
    |
    | For example we recommend using this convention
    | 'table_name' => 'fully qualified model class name'.
    | or
    | 'table_name' => App\Models\User::class.
    |
    */
    'wallet-morph-map-users' => [
        'users' => 'App\Models\User',
        'services' => 'App\Models\Service',
    ],
    'wallet-morph-map-services' => [
        'services' => 'App\Models\Service',
    ],
];