<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 28/06/2018
 * Time: 12:13 PM
 */

namespace App\Di;

use App\Interfaces\DiInterface;

class Di implements DiInterface
{
    /**
     * List of registered services
     */
    protected $sharedInstances;

    /**
     * List of resolved services
     */
    protected $resolvedInstances;

    public function __construct()
    {
    }

    /**
     * Registers an "always shared" service in the services container
     *
     * @param string $name
     * @param mixed  $definition
     *
     * @return \App\Interfaces\ServiceProviderInterface
     */
    public function registerService($name, $definition)
    {
        $this->offsetSet($name, new ServiceProvider($name, $definition));

        return $this->getService($name);
    }

    /**
     * Returns a ServiceProvider instance
     *
     * @param string $name
     *
     * @return \App\Interfaces\ServiceProviderInterface|bool
     */
    public function getService($name)
    {
        if ( ! isset($this->sharedInstances[$name]))
        {
            return false;
        }
        return $this->sharedInstances[$name];
    }

    /**
     * Returns resolved services or request a service be resolved if not available in service container.
     * Subsequent requests for this service will return the same instance
     *
     * @param string $name
     * @param array  $parameters
     *
     * @return mixed
     */
    public function getShared($name, $parameters = null)
    {
        if ( ! isset($this->resolvedInstances[$name]))
        {
            if ( ! $service = $this->getService($name))
            {
                return false;
            }
            $this->resolvedInstances[$name] = $service->resolve($parameters);
        }
        return $this->resolvedInstances[$name];
    }

    /**
     * Return the services registered in the DI
     *
     * @return \Phalcon\Di\Service[]
     */
    public function getServices()
    {
        return $this->sharedInstances;
    }

    /**
     * Check if a service is registered using the array syntax
     *
     * @param string $name
     *
     * @return bool
     */
    public function offsetExists($name)
    {
        return isset($this->sharedInstances[$name]);
    }

    /**
     * Removes a service from the services registry using the array syntax
     * also removes shared Instances
     *
     * @param string $name
     *
     * @return bool
     */
    public function offsetUnset($name)
    {
        if (array_key_exists($name, $this->sharedInstances))
        {
            unset($this->sharedInstances[$name]);

            return true;
        }

        return false;
    }

    /**
     * Allows to obtain a shared service using the array syntax
     *
     * <code>
     * var_dump($di["request"]);
     * </code>
     *
     * @param string $name
     *
     * @return mixed
     */
    public function offsetGet($name)
    {
        if ( ! isset($this->sharedInstances[$name]))
        {
            return false;
        }
        return $this->sharedInstances[$name];
    }

    public function offsetSet($name, $value)
    {
        $this->sharedInstances[$name] = $value;
    }
}
