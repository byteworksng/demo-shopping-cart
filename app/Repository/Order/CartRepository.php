<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 27/06/2018
 * Time: 11:50 PM
 */

namespace App\Repository\Order;

use App\Models\Order\Cart;
use App\Repository\AbstractRepository;

class CartRepository extends AbstractRepository
{
    public function fetchAll()
    {
        $resultSet = parent::fetchAll();

        return $this->populateAndGet(Cart::class, $resultSet);
    }

    public function fetch($params)
    {
        $resultSet = parent::fetch($params);

        return $this->populateAndGet(Cart::class, $resultSet);
    }

    public function add(array $param, $closeSession = false)
    {
        $param['cartId'] = hash('md4', uniqid(mt_rand()));

        return parent::add($this->parseData(Cart::class, $param), $closeSession);
    }

    public function update($param, $closeSession = false)
    {

        return parent::update($this->parseData(Cart::class, $param), $closeSession);
    }
}
