<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 28/06/2018
 * Time: 9:17 PM
 */

namespace App\Http\Controller;

use App\Interfaces\ControllerInterface;
//use App\Traits\HydratingTraits;
use App\Traits\Logger;

/**
 * Class Controller
 *
 * @package App\Http\Controller
 */
abstract class Controller implements ControllerInterface
{
    use  Logger;

    /**
     * executes method on the controller.
     *
     * @param $method
     * @param $action
     *
     * @return mixed
     */
    public function callAction($method, $parameters)
    {
        return call_user_func_array([$this, $method], $parameters);
    }

    public function __call($name, $arguments)
    {
        throw new \BadMethodCallException(sprintf('Method %s::%s does not exist.', static::class, $name));
    }
}
