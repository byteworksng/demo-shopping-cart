<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 28/06/2018
 * Time: 2:10 AM
 */

namespace App;

use App\Facade\Facade;
use App\Interfaces;


class App
{
    private $di;

    public function __construct(Interfaces\DiInterface $di)
    {
        $this->di = $di;
    }

    public function handle()
    {
        Facade::setFacadeApplication($this->di);

        $this->di->getShared('session')->run();
        $response = $this->di->getShared('route')->run();

        // todo: add response object to handle this as send method
        if (is_array($response) || is_object($response))
        {
            $response = json_encode($response);
        }
        echo $response;

    }

    public static function make($service)
    {
        return Facade::getFacadeApplication()->getService($service)->resolve();
    }

}
