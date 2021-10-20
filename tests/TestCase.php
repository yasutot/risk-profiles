<?php

use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $reflectionClass;

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    protected function getReflection($class)
    {
        if ($this->reflectionClass) {
            return $this->reflectionClass;
        }

        $this->reflectionClass = new ReflectionClass($class);

        return $this->reflectionClass;
    }

    protected function getProtectedMethod($reflection, string $methodName)
    {
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }

    protected function setProtectedPropertyValue($reflection, $mockedObj, string $property, $value)
    {
        $reflectionValue = $reflection->getProperty($property);

        $reflectionValue->setAccessible(true);

        $reflectionValue->setValue($mockedObj, $value);
    }

    protected function getProtectedPropertyValue($object, string $property)
    {
        $reflection = new ReflectionObject($object);
        $reflectionProperty = $reflection->getProperty($property);
        $reflectionProperty->setAccessible(true);

        return $reflectionProperty->getValue($object);
    }
}
