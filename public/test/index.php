<?php

$config = [
    'components' => [
        'cache' => 'libs\Cache',
        'test' => 'libs\Test'
    ]
];

spl_autoload_register(function ($class) {
    $file = ROOT . '/' . str_replace('\\', '/', $class) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

class Registry
{
    public static array $objects = [];

    protected static ?Registry $instance = null;

    protected function __construct()
    {
        global $config;
        foreach ($config['components'] as $name => $component) {
self::$objects
        }
    }

    public static function instance(): Registry
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

}