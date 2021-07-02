<?php

//Dev
const DEBUG = 1;

//Prod
//const DEBUG = 0;

class NotFoundException extends Exception
{
    public function __construct($message = "", $code = 404)
    {
        parent::__construct($message, $code);
    }
}


class  ErrorHandler
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
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @return bool
     */
    public function errorHandler(int $errno, string $errstr, string $errfile, int $errline): bool
    {
        error_log("[" . date('Y-m-d H:i:s') . "] Текст ошибки: {$errstr} | Файл в котором произошла 
        ошибка: {$errfile} | Строка в которой произошла ошибка: {$errline}\n<=======================>\n", 3,
            __DIR__ . '/errors.log');
        $this->displayError($errno, $errstr, $errfile, $errline);
        ini_set('display_errors', 1);
        return true;
    }

    /**
     *Обработчик фатальных ошибок
     */
    public function fatalErrorHandler(): void
    {

        $error = error_get_last();
        if (!empty($error) && $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)) {
            error_log("[" . date('Y-m-d H:i:s') . "] Текст ошибки: {$error['message']} | Файл в котором произошла 
        ошибка: {$error['file']} | Строка в которой произошла ошибка: {$error['line']}\n<=======================>\n", 3,
                __DIR__ . '/errors.log');
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
        error_log("[" . date('Y-m-d H:i:s') . "] Текст ошибки: {$exception->getMessage()} | Файл в котором произошла 
        ошибка: {$exception->getFile()} | Строка в которой произошла ошибка: {$exception->getLine()}\n<=======================>\n", 3,
            __DIR__ . '/errors.log');
//        var_dump($exception);
        $this->displayError("Исключение", $exception->getMessage(), $exception->getFile(), $exception->getLine(),
            $exception->getCode());
    }

    /**
     * Подключает шаблон для dev или prod
     * @param mixed $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @param int $responseCode
     */
    public function displayError(mixed $errno, string $errstr, string $errfile, int $errline, $responseCode = 500): void
    {
        http_response_code($responseCode);
        if (DEBUG) {
            require 'views/dev.php';
        } else {
            require 'views/prod.php';
        }
        die();
    }

}


new ErrorHandler();
//$test = 123;
//echo $test;
//test();
//throw new NotFoundException('Страница не найдена');
throw new \Exception('Oops error', 503);