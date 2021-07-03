<?php


namespace core;


class ErrorHandler
{
    /**
     * В конструкторе проверяется, включено ли отображение ошибок(dev или prod мод)и задается собственный обработчик ошибок
     * ErrorHandler constructor.
     */
    public function __construct()
    {
        if (DEBUG) {
            error_reporting(-1);
        } else {
            error_reporting(0);
        }
        set_error_handler([$this, 'errorHandler']);
        ob_start();
        register_shutdown_function([$this, 'fatalErrorHandler']);
        set_exception_handler([$this, 'exceptionHandler']);
    }

    /**
     * Самописный обработчик ошибок
     * @param int $errNo
     * @param string $errStr
     * @param string $errFile
     * @param int $errLine
     * @return bool
     */
    public function errorHandler(int $errNo, string $errStr, string $errFile, int $errLine): bool
    {
        $this->logErrors($errStr, $errFile, $errLine);
//        error_log("[" . date('Y-m-d H:i:s') . "] Текст ошибки: {$errstr} | Файл в котором произошла
//        ошибка: {$errfile} | Строка в которой произошла ошибка: {$errline}\n<=======================>\n", 3,
//            __DIR__ . '/errors.log');
        $this->displayError($errNo, $errStr, $errFile, $errLine);
//        ini_set('display_errors', 1);
        return true;
    }

    /**
     *Обработчик фатальных ошибок
     */
    public function fatalErrorHandler(): void
    {

        $error = error_get_last();
        if (!empty($error) && $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)) {
            $this->logErrors($error['message'], $error['file'], $error['line']);
//            error_log("[" . date('Y-m-d H:i:s') . "] Текст ошибки: {$error['message']} | Файл в котором произошла
//        ошибка: {$error['file']} | Строка в которой произошла ошибка: {$error['line']}\n<=======================>\n", 3,
//                __DIR__ . '/errors.log');
            ob_end_clean();
            $this->displayError($error['type'], $error['message'], $error['file'], $error['line']);
        } else {
            ob_end_flush();
        }

    }


    /**
     * Обработчик исключений
     * @param object $exception
     */
    public function exceptionHandler(object $exception): void
    {
        $this->logErrors($exception->getMessage(), $exception->getFile(), $exception->getLine());
//        error_log("[" . date('Y-m-d H:i:s') . "] Текст ошибки: {$exception->getMessage()} | Файл в котором произошла
//        ошибка: {$exception->getFile()} | Строка в которой произошла ошибка: {$exception->getLine()}\n<=======================>\n", 3,
//            __DIR__ . '/errors.log');
//        var_dump($exception);
        $this->displayError("Исключение", $exception->getMessage(), $exception->getFile(), $exception->getLine(),
            $exception->getCode());
    }

    /**
     * Осуществляет запись логов в log файл
     * @param string $message
     * @param string $file
     * @param string $line
     */
    protected function logErrors(string $message = '', string $file = '', string $line = ''): void
    {
        error_log("[" . date('Y-m-d H:i:s') . "] Текст ошибки: {$message} | Файл в котором произошла 
        ошибка: {$file} | Строка в которой произошла ошибка: {$line}\n<=======================>\n", 3,
            ROOT . '/tmp/errors.log');
    }

    /**
     * Подключает шаблон для dev или prod
     * @param mixed $errNo
     * @param string $errStr
     * @param string $errFile
     * @param int $errLine
     * @param int $responseCode
     */
    public function displayError(mixed $errNo, string $errStr, string $errFile, int $errLine, $responseCode = 500): void
    {
        http_response_code($responseCode);
        if ($responseCode == 404) {
            require WWW . '/errors/404.html';
            die();
        }
        if (DEBUG) {
            require WWW . '/errors/dev.php';
        } else {
            require WWW . '/errors/prod.php';
        }
        die();
    }

}