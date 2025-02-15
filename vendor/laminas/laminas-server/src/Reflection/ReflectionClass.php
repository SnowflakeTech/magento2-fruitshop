<?php

/**
 * @see       https://github.com/laminas/laminas-server for the canonical source repository
 */

namespace Laminas\Server\Reflection;

use ReflectionClass as PhpReflectionClass;

use function call_user_func_array;
use function is_array;
use function is_string;
use function method_exists;
use function preg_match;
use function str_starts_with;

/**
 * Class/Object reflection
 *
 * Proxies calls to a ReflectionClass object, and decorates getMethods() by
 * creating its own list of {@link Laminas\Server\Reflection\ReflectionMethod}s.
 */
class ReflectionClass
{
    /**
     * Optional configuration parameters; accessible via {@link __get} and
     * {@link __set()}
     *
     * @var array
     */
    protected $config = [];

    /**
     * Array of {@link \Laminas\Server\Reflection\Method}s
     *
     * @var array
     */
    protected $methods = [];

    /**
     * Namespace
     *
     * @var string
     */
    protected $namespace;

    /**
     * ReflectionClass object
     *
     * @var PhpReflectionClass
     */
    protected $reflection;

    /**
     * Reflection class name (needed for serialization)
     *
     * @var string
     */
    protected $name;

    /**
     * Constructor
     *
     * Create array of dispatchable methods, each a
     * {@link Laminas\Server\Reflection\ReflectionMethod}. Sets reflection object property.
     *
     * @param string $namespace
     * @param mixed $argv
     */
    public function __construct(PhpReflectionClass $reflection, $namespace = null, $argv = false)
    {
        $this->reflection = $reflection;
        $this->name       = $reflection->getName();
        $this->setNamespace($namespace);

        $argv = is_array($argv) ? $argv : [];

        foreach ($reflection->getMethods() as $method) {
            // Don't aggregate magic methods
            if (str_starts_with($method->getName(), '__')) {
                continue;
            }

            if ($method->isPublic()) {
                // Get signatures and description
                $this->methods[] = new ReflectionMethod($this, $method, $this->getNamespace(), $argv);
            }
        }
    }

    /**
     * Proxy reflection calls
     *
     * @param string $method
     * @param array $args
     * @throws Exception\BadMethodCallException
     * @return mixed
     */
    public function __call($method, $args)
    {
        if (method_exists($this->reflection, $method)) {
            return call_user_func_array([$this->reflection, $method], $args);
        }

        throw new Exception\BadMethodCallException('Invalid reflection method');
    }

    /**
     * Retrieve configuration parameters
     *
     * Values are retrieved by key from {@link $config}. Returns null if no
     * value found.
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->config[$key] ?? null;
    }

    /**
     * Set configuration parameters
     *
     * Values are stored by $key in {@link $config}.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->config[$key] = $value;
    }

    /**
     * Return array of dispatchable {@link \Laminas\Server\Reflection\ReflectionMethod}s.
     *
     * @access public
     * @return array
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * Get namespace for this class
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Set namespace for this class
     *
     * @param string $namespace
     * @throws Exception\InvalidArgumentException
     * @return void
     */
    public function setNamespace($namespace)
    {
        if (empty($namespace)) {
            $this->namespace = '';
            return;
        }

        if (! is_string($namespace) || ! preg_match('/[a-z0-9_\.]+/i', $namespace)) {
            throw new Exception\InvalidArgumentException('Invalid namespace');
        }

        $this->namespace = $namespace;
    }

    /**
     * Wakeup from serialization
     *
     * Reflection needs explicit instantiation to work correctly. Re-instantiate
     * reflection object on wakeup.
     *
     * @return void
     */
    public function __wakeup()
    {
        $this->reflection = new PhpReflectionClass($this->name);
    }

    /**
     * @return string[]
     */
    public function __sleep()
    {
        return ['config', 'methods', 'namespace', 'name'];
    }
}
