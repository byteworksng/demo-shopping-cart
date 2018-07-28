<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 14/07/2018
 * Time: 1:21 PM
 */

namespace App\Http\Controller\Cart;

use App\Http\Controller\BaseController as Controller;
use App\Interfaces\RepositoryInterface;

class CartController extends Controller
{
    private $cartRepository;
    private $orderRepository;

    public function __construct(RepositoryInterface $cart, RepositoryInterface $order)
    {
        $this->cartRepository = $cart;
        $this->orderRepository = $order;
    }

    public function count()
    {
        return count($this->cartRepository->fetchAll());
    }

    public function addToCart()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        return $this->cartRepository->add($data, true);
    }

    public function reviewCart()
    {
        $data = $this->cartRepository->fetchAll();

        if (isset($data[0]) && $ref = $data[0]->orderRef)
        {
            $order = $this->orderRepository->fetch(['ref' => $ref]);
        } else
        {
            $order = $this->orderRepository->calculateItemsTotals(...$data);
        }

        return $this->render('detail', compact('data', 'order'));
    }

    public function removeItem($param)
    {

        $param = ['cartId' => $param];
        $this->cartRepository->remove($param);
    }
}
