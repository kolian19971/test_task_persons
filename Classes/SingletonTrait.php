<?php

trait SingletonTrait
{
    private static $instance = null;

    protected function __construct(){}

    protected function __clone(){}

    public function __wakeup()
    {
        throw new Exception('Cannot unserialize a Mankind');
    }

    /**
     * Get instance of Mankind
     *
     * @return static
     */
    public static function getInstance(): static
    {
        if (!isset(self::$instance))
            self::$instance = new static();

        return self::$instance;
    }
}