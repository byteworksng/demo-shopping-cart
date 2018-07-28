<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 28/06/2018
 * Time: 12:19 PM
 */

namespace App\Interfaces;

interface DiInterface extends \ArrayAccess
{
    /**
     * Registers an "always shared" service in the services container
     *
     * @param string $name
     * @param mixed  $definition
     *
     * @return \App\Interfaces\ServiceProviderInterface
     */
    public function registerService($name, $definition);


    /**
     * Returns a ServiceProvider instance
     *
     * @param string $name
     *
     * @return \App\Interfaces\ServiceProviderInterface
     */
    public function getService($name);
}
