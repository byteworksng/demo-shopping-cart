<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 28/06/2018
 * Time: 12:40 AM
 */

namespace App\Interfaces;

interface RouteInterface
{
    public function dispatch();

    public function matchRoute($requestPath, $routePath);

    public function setController($controller);

    public function setAction($action);

    public function setParam(array $param);
}
