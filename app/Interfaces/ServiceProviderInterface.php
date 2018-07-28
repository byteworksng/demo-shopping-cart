<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 04/07/2018
 * Time: 1:08 PM
 */

namespace App\Interfaces;

interface ServiceProviderInterface
{
    /**
     * Returns the service's name
     *
     * @param string
     */
    public function getName();


    /**
     * Resolves the service
     *
     * @param array       $parameters
     * @param DiInterface $dependencyInjector
     *
     * @return mixed
     */
    public function resolve(array $parameters = null, DiInterface $dependencyInjector = null);

}
