<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 27/06/2018
 * Time: 7:25 PM
 */
return [
        'get'    => [
                '/'                    => "App\Http\Controller\IndexController@index",
                '/order/cart'          => \App\Http\Controller\Cart\CartController::class . "@reviewCart",
                '/order/cart/count'    => \App\Http\Controller\Cart\CartController::class . "@count",
                '/order/receipt'       => \App\Http\Controller\Order\OrderController::class . "@receipt",
                '/order/review/{id}'   => \App\Http\Controller\Order\OrderController::class . "@review",
                '/product/rating/{id}' => \App\Http\Controller\Rating\RatingController::class . "@getAvg",
                '/wallet'              => \App\Http\Controller\Wallet\WalletController::class . "@fetchWallet"
        ],
        'post'   => [
                '/order/cart'     => \App\Http\Controller\Cart\CartController::class . "@addToCart",
                '/order/pay'      => \App\Http\Controller\Order\OrderController::class . "@pay",
                '/order/checkout' => \App\Http\Controller\Order\OrderController::class . "@checkout",
                '/product/rating' => \App\Http\Controller\Rating\RatingController::class . "@add",
        ],
        'delete' => [
                '/cart/remove/{id}'  => \App\Http\Controller\Cart\CartController::class . "@removeItem",
                '/order/remove/{id}' => \App\Http\Controller\Order\OrderController::class . "@remove"
        ],


];
