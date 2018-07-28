<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 09/07/2018
 * Time: 2:19 PM
 */

namespace App\Repository\Product;

use App\Models\Product\Product;
use App\Repository\AbstractRepository;

class ProductRepository extends AbstractRepository
{


    public function fetch($params)
    {

        $resultSet = parent::fetch($params);

        $models = [];
        foreach ($resultSet as $result)
        {
            array_push($models, Product::hydrate($result));
        }

        return $models;

    }

    public function fetchAll()
    {
        $resultSet = parent::fetchAll();
        $models = [];
        foreach ($resultSet as $result)
        {
            array_push($models, Product::hydrate($result));
        }

        return $models;
    }
}
