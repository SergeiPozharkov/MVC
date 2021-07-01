<?php


namespace core;


trait TSingleton
{
    /**
     * Содержит объект текущего класса
     * ? перед типом свойства - значит, что свойство может быть указанного или типа null т.е. имеет "обнуляемый" тип
     * @var object|null
     */
    protected static ?object $instance = null;

    /**
     * Проверяет создан ли объект текущего класса, если нет, то создает его
     * @return object
     */
    public static function instance(): object
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

}