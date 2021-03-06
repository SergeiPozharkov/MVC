<?php

$config = [
    'components' => [
        'cache' => 'classes\Cache',
        'test' => 'classes\Test'
    ]
];

spl_autoload_register(function ($class) {
    $file = str_replace('\\', '/', $class) . '.php';

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
            self::$objects[$name] = new $component;
        }
    }

    public static function instance(): Registry
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __get(string $name)
    {
        if (is_object($objects[$name])) {
            return self::$objects[$name];
        }
    }

    public function __set(string $name, $object): void
    {
        if (!isset(self::$objects[$name])) {
            self::$objects[$name] = new $object;
        }
    }

    public function getList()
    {
        echo '<pre>';
        var_dump(self::$objects);
        echo '</pre>';
    }

}

$app = new Registry::instance();

$app->getList();

$app->test->run();

$app->test2 = 'test message';