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
    protected string $pk = 'id';

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
     * @param string $sql
     * @return bool
     */
    public function query(string $sql): bool
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

    public function findOne(mixed $id, string $field = ''): array
    {
        $field = $field ?: $this->pk;
        $sql = "SELECT * FROM {$this->tableName} WHERE $field = ? LIMIT 1";
        return $this->pdo->query($sql, [$id]);

    }

    public function findBySql($sql, $params = []): array
    {
        return $this->pdo->query($sql, $params);
    }

    public function findLike(string $str, string $field, string $table = ''): array
    {
        $table = $table ?: $this->tableName;
        $sql = "SELECT * FROM $table WHERE $field LIKE ?";
        return $this->pdo->query($sql, ['%' . $str . '%']);
    }

}