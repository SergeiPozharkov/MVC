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

    public function get(string $key): array|bool
    {
        $file = CACHE . '/' . md5($key) . '.txt';
        if (file_exists($file)) {
            $content = unserialize(file_get_contents($file));
            if (time() <= $content['end_time']) {
                return $content['data'];
            }
            unlink($file);
        }
        return false;
    }

    public function delete(string $key): void
    {
        $file = CACHE . '/' . md5($key) . '.txt';
        if (file_exists($file)) {
            unlink($file);
        }
    }

}