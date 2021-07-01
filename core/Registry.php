<?php


namespace core;


class Registry
{
    use TSingleton;

    public static array $objects = [];

//    protected static ?Registry $instance = null;

    protected function __construct()
    {
        $config = require ROOT . '/config/config.php';
        foreach ($config['components'] as $name => $component) {
            self::$objects[$name] = new $component;
        }
    }

//    public static function instance(): Registry
//    {
//        if (self::$instance === null) {
//            self::$instance = new self();
//        }
//        return self::$instance;
//    }

    public function __get(string $name)
    {
        if (is_object(self::$objects[$name])) {
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