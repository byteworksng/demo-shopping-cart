<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 28/06/2018
 * Time: 12:11 AM
 */

namespace App\Di;

use App\Config;
use App\Database;
use App\Gateway\SessionGateway;
use App\Gateway\TableGateway;
use App\Http\Controller\Cart\CartController;
use App\Http\Controller\Order\OrderController;
use App\Http\Controller\Rating\RatingController;
use App\Http\Controller\Wallet\WalletController;
use App\Models\Order\Cart;
use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Models\Rating\Rating;
use App\Models\Wallet\Wallet;
use App\Repository\Rating\RatingRepository;
use App\Repository\Order\CartRepository;
use App\Repository\Order\OrderRepository;
use App\Repository\Product\ProductRepository;
use App\Repository\Wallet\WalletRepository;
use App\Sessions\SessionManager;
use App\Sessions\SessionStorage;
use App\Router;

/**
 * Class FactoryDefault
 * Registers all service definitions and including dependencies and makes them available on demand.
 * No service is instantiated prior to when it is requested.
 *
 * @package App\Di
 */
class FactoryDefault extends Di
{
    public function __construct()
    {
        parent::__construct();

        // the config object
        $this->registerService('config', function () {
            $options = require(BASE_PATH . '/config/config.php');

            return new Config($options);
        });


        // the session manager
        $this->registerService('session', function () {
            $config = $this->getShared('config');
            $session = $this->getShared('sessionStorage');

            return new SessionManager($session, $config);
        });


        // the router object
        $this->registerService('route', function () {
            $path = $this->getShared('config')->get('route');
            $routes = require_once($path);

            return new Router($routes, $this);
        });


        // the database adapter
        $this->registerService('db', function () {
            $database = $this->getShared('config')->get('database');
            $dsn = "$database->driver:host=$database->host;dbname=$database->dbname;port=$database->port;charset=$database->charset";

            return new Database($dsn, $database->username, $database->password);
        });


        // the session adapter
        $this->registerService('sessionStorage', function () {

            return new SessionStorage();
        });


        // Repository and Controllers - todo: may move to dedicated service provider files
        $this->registerService('productRepository', function () {
            $database = $this->getShared('db');

            return new ProductRepository(new TableGateway('product', $database), new Product());
        });


        $this->registerService('ratingRepository', function () {
            $database = $this->getShared('db');
            $session = $this->getShared('sessionStorage');

            return new RatingRepository(new TableGateway('rate', $database), new SessionGateway('rate', $session), new Rating());
        });


        $this->registerService(RatingController::class, function () {
            $rating = $this->getShared('ratingRepository');

            return new RatingController($rating);
        });


        $this->registerService('orderRepository', function () {
            $session = $this->getShared('sessionStorage');

            return new OrderRepository(new SessionGateway('order', $session), new Order());
        });


        $this->registerService('cartRepository', function () {
            $session = $this->getShared('sessionStorage');

            return new CartRepository(new SessionGateway('cart', $session), new Cart());
        });


        $this->registerService(OrderController::class, function () {
            $order = $this->getShared('orderRepository');
            $cart = $this->getShared('cartRepository');
            $wallet = $this->getShared('walletRepository');

            return new OrderController($order, $cart, $wallet);
        });


        $this->registerService(CartController::class, function () {
            $cart = $this->getShared('cartRepository');
            $order = $this->getShared('orderRepository');

            return new CartController($cart, $order);
        });


        $this->registerService(WalletController::class, function () {
            $wallet = $this->getShared('walletRepository');

            return new WalletController($wallet);
        });


        $this->registerService('walletRepository', function () {
            $session = $this->getShared('sessionStorage');

            return new WalletRepository(new SessionGateway('wallet', $session), new Wallet());
        });


    }
}
