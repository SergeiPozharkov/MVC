<?php


namespace libs;


class Cache
{

    public function __construct()
    {

    }

    /**
     * Записывает данные в файл кеша
     * @param string $key
     * @param array $data
     * @param int $seconds
     * @return bool
     */
    public function set(string $key, array $data, int $seconds = 3600): bool
    {
        $content = [];
        $content['data'] = $data;
        $content['end_time'] = time() + $seconds;
        if (file_put_contents(CACHE . '/' . md5($key) . '.txt', serialize($content))) {
            return true;
        }
        return false;
    }

    public function get()
    {

    }


}