<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 08/07/2018
 * Time: 12:44 AM
 */

namespace App\Facade;

use App\Interfaces\DiInterface;
use RuntimeException;

/**
 * Class Facade
 * This is inspired by Laravel Facades, provides a convenient way to return services from the DI container.
 * A simple service locator.
 *
 * @package App\Facade
 */
class Facade
{
    /**
     * The resolved object instances.
     *
     * @var array
     */
    protected static $resolvedInstance;

    /**
     * The active application container.
     *
     * @var DiInterface
     */
    protected static $app;


    public static function setFacadeApplication(DiInterface $app)
    {
        static::$app = $app;
    }

    public static function getFacadeApplication()
    {
        return static::$app;
    }

    /**
     * Returns the name of object to resolve from DI
     *
     * @return string
     */
    public static function getInstanceName()
    {
        throw new RuntimeException('Facade does not implement getInstanceName method.');
    }

    /**
     * Does the magic of dynamically calling methods in instance
     *
     * @param $method
     * @param $arguments
     *
     * @return mixed
     * @throws \RuntimeException
     */
    public static function __callStatic($method, $arguments)
    {
        if ($instance = static::getInstance())
        {
            return $instance->$method(...$arguments);
        }
        throw new RuntimeException("No instance located");

    }

    /**
     * Get the object.
     *
     * @return mixed
     */
    protected static function getInstance()
    {
        return static::resolveInstance(static::getInstanceName());
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    protected static function resolveInstance($name)
    {
        if (isset(static::$resolvedInstance[$name]))
        {
            return static::$resolvedInstance[$name];
        }
        return static::$resolvedInstance[$name] = static::getFacadeApplication()->getShared($name);
    }
}
