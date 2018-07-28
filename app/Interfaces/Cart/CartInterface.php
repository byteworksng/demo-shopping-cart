<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 27/06/2018
 * Time: 11:40 PM
 */

namespace App\Interfaces\Cart;

interface CartInterface
{

    public function add(array $item);

    public function remove($item);

    public function update($item);
}
