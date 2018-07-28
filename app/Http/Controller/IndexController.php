<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 28/06/2018
 * Time: 9:27 PM
 */

namespace App\Http\Controller;

use App\App;

class IndexController extends BaseController
{
    public function index()
    {
        $productRepository = App::make('productRepository');
        $ratingRepository = App::make('ratingRepository');
        $products = $productRepository->fetchAll();
        array_walk($products, function (&$product) use ($ratingRepository) {
            $product->ratingAvg = $ratingRepository->getRatingAvg($product->id);
        });

        return $this->render(__FUNCTION__, ['name' => 'Shop', 'data' => $products]);
    }
}
