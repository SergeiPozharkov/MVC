<?php


namespace core;

/**
 *Класс для подключения к БД через PDO
 */
class Db
{

    protected object $pdo;
    /**
     * Содержит объект текущего класса
     * ? перед типом свойства - значит, что свойство может быть указанного или типа null т.е. имеет "обнуляемый" тип
     * @var Db|null
     */
    protected static ?Db $instance = null;
    /**
     * Содержит количество выполненных sql запросов
     * @var int
     */
    public static int $countSql = 0;
    /**
     * Содержит выполняемый запрос к БД
     * @var array
     */
    public static array $queries = [];


    protected function __construct()
    {
        $db = require ROOT . '/config/config_db.php';
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ];
        $this->pdo = new \PDO($db['dsn'], $db['user'], $db['pass'], $options);
    }

    /**
     * Проверяет создае ли объект текущего класса, если нет, то создает его
     * @return Db
     */
    public static function instance(): Db
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Подготавливает sql запрос к выполнению(prepare)(PDO)
     * @param string $sql
     * @return bool
     */
    public function execute(string $sql): bool
    {
        self::$countSql++;
        self::$queries[] = $sql;
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();
    }

    /**
     * Выполняет запрос не требующий выборки(вывода) элементов sql таблицы
     * @param string $sql
     * @return array
     */
    public function query(string $sql): array
    {
        self::$countSql++;
        self::$queries[] = $sql;
        $stmt = $this->pdo->prepare($sql);
        $res = $stmt->execute();
        if ($res !== false) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        return [];
    }

}