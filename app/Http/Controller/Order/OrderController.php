<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 28/06/2018
 * Time: 9:19 PM
 */

namespace App\Http\Controller\Order;

use App\Facade\Config;
use App\Http\Controller\BaseController as Controller;
use App\Interfaces\RepositoryInterface;

class OrderController extends Controller
{
    private $orderRepository;

    private $cartRepository;

    private $walletRepository;

    public function __construct(RepositoryInterface $order, RepositoryInterface $cart, RepositoryInterface $wallet)
    {
        $this->orderRepository = $order;
        $this->cartRepository = $cart;
        $this->walletRepository = $wallet;
    }


    public function receipt()
    {
        $order = $this->orderRepository->fetchAll()[0];
        $orderItems = $this->cartRepository->fetchAll();

        if ( ! isset($order))
        {
            $this->redirect(Config::get('baseUri'), 303);
        }

        // clear order from session store
        $this->cartRepository->removeAll();
        $this->orderRepository->removeAll();

        return $this->render('receipt', compact('order', 'orderItems'));
    }

    public function checkout()
    {
        $cart = $_POST['cart'];
        $order = $_POST['order'];

        if (empty($order['ref']))
        {
            $ref = hash('md4', uniqid(mt_rand()));
            $order['ref'] = $ref;
            $this->orderRepository->add($order);
        } else
        {
            $ref = $order['ref'];
            $this->orderRepository->update($order);
        }

        if (isset($cart))
        {
            array_walk($cart, function (&$item, $idx) use ($ref) {

                $item['orderRef'] = $ref;

            });


            $this->cartRepository->update($cart, true);
        }


        return $ref;
    }

    public function review($id)
    {
        $order = $this->orderRepository->fetch(['ref' => $id]);
        $lineItems = $this->cartRepository->fetch(['orderRef' => $id]);

        return $this->render('review', ['lineItems' => $lineItems, 'order' => $order]);
    }

    public function pay()
    {
        $data = $_POST['ref'];

        $order = $this->orderRepository->fetch(['ref' => $data]);

        if ($this->walletRepository->unloadWallet($order->gross))
        {
            $txnId = hash('md4', uniqid(mt_rand()));
            $order->txnId = $txnId;
            $this->orderRepository->update($order->extract(), true);

            return true;
        }

        return false;
    }
}
