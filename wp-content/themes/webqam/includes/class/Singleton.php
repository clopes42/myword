<?php

/**
 * Class Singleton
 *
 * @author Benjamin Gondy <bgondy@webqam.fr>
 */
abstract class Singleton
{
    protected static $instance;

    abstract protected function __construct();

    /**
     * @return Singleton
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}