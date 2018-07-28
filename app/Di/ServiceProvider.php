<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 04/07/2018
 * Time: 1:08 PM
 */

namespace App\Di;

use App\Interfaces\DiInterface;
use App\Interfaces\ServiceProviderInterface;

/**
 * Class ServiceProvider
 *
 * @package App\Di
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @var
     */
    protected $name;

    /**
     * @var
     */
    protected $definition;

    /**
     * @var
     */
    protected $sharedInstance;

    /**
     * ServiceProvider constructor.
     *
     * @param $name
     * @param $definition
     */
    public function __construct($name, $definition)
    {
        $this->name = $name;
        $this->definition = $definition;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets/Resets the shared instance related to the service
     *
     * @param mixed $sharedInstance
     */
    public function setSharedInstance($sharedInstance)
    {
        $this->sharedInstance = $sharedInstance;
    }

    /**
     * Resolves/Instantiates an object based on its definitions stored in service container.
     *  Assoc array is required to represent arguments as keys
     * are matched to respective object properties. Arguments are optional
     * non-the-less.
     * Return an instance of the resolved object.
     *
     *
     * @throws \Exception
     *
     * @param array|null                       $parameters
     * @param \App\Interfaces\DiInterface|null $dependencyInjector
     *
     * @return mixed
     */
    public function resolve(array $parameters = null, DiInterface $dependencyInjector = null)
    {

        if (isset($dependencyInjector))
        {
            $instance = $dependencyInjector->getShared($this->getName(), $parameters);
        }

        if ( ! isset($instance))
        {

            if ($this->definition instanceof \Closure)
            {
                $instance = $this->executeCallable($this->definition, $parameters);
            } else
            {
                $instance = $this->makeInstance($this->definition, $parameters);
            }
        }
        // todo: determine other dependencies required by this service and store them - sharedInstance
        //$this->setSharedInstance($instance);

        return $instance;
    }

    /**
     * Execute callables
     *
     * @param $definition
     * @param $params
     *
     * @return mixed
     */
    private function executeCallable($definition, $params)
    {
        if ( ! isset($params))
        {
            $instance = $definition();
        } else
        {
            $instance = $definition(...$params);//;call_user_func_array($definition, $params);
        }
        return $instance;
    }

    /**
     * Intantiate class
     *
     * @param $definition
     * @param $params
     *
     * @return mixed
     * @throws \Exception
     */
    private function makeInstance($definition, $params)
    {
        if (class_exists($definition))
        {
            if ( ! isset($params))
            {
                $instance = new $definition();
            } else
            {
                $instance = new $definition(...$params);
            }

        } else
        {
            throw new \Exception("No class called $definition found. may have not been loaded");
        }

        return $instance;
    }
}
