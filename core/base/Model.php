<?php


namespace core\base;

use core\Db;

/**
 *Базовый класс модели
 */
abstract class Model
{

    protected object $pdo;
    protected string $tableName;

    /**
     * Создается объект для подключения к БД через PDO
     * Model constructor.
     */
    public function __construct()
    {
        $this->pdo = Db::instance();
    }

    /**
     * Возвращает подготовленный запрос
     * @param $sql
     * @return bool
     */
    public function query($sql): bool
    {
        return $this->pdo->execute($sql);
    }

    /**
     * Возвращает все элементы sql таблицы
     * @return array
     */
    public function findAll(): array
    {
        $sql = "SELECT * FROM {$this->tableName}";
        return $this->pdo->query($sql);
    }

}