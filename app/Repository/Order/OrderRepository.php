<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 27/06/2018
 * Time: 11:50 PM
 */

namespace App\Repository\Order;

use App\Models\Order\Cart;
use App\Models\Order\Order;
use App\Repository\AbstractRepository;

class OrderRepository extends AbstractRepository
{
    public function fetchAll()
    {
        $resultSet = parent::fetchAll();

        return $this->populateAndGet($this->model, $resultSet);
    }

    public function fetch($params)
    {
        $resultSet = parent::fetch($params);

        return $this->populateAndGet($this->model, $resultSet)[0];
    }

    public function calculateItemsTotals(Cart ...$data)
    {
        $totals = [];
        foreach ($data as $cart)
        {
            if ($cart->total)
            {
                array_push($totals, $cart->total);
            } else
            {
                //fail safe
                $total = $cart->qty * (float)$cart->price;
                array_push($totals, number_format($total, 2));
            }
        }
        $this->model->subTotal = number_format(array_sum($totals), 2);
        $this->model->gross = $this->model->subTotal;

        return $this->model;
    }

    public function add(array $param, $closeSession = false)
    {
        return parent::add($this->parseData($this->model, $param), $closeSession);
    }

    public function update($param, $closeSession = false)
    {

        return parent::update($this->parseData($this->model, [$param]), $closeSession);
    }
}
